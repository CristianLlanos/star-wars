import { useCallback, useMemo, useState } from 'react';
import { useLoading } from '@/hooks/useLoading';

type ValueFactory<T> = () => T;

type UseStarWarsRequestOptions<T> = {
  defaultValue: ValueFactory<T>;
  errorMessage: string;
  request: (input: string) => Promise<T>;
};

type UseStarWarsRequestReturn<T> = {
  data: T;
  error: string | null;
  isLoading: boolean;
  execute: (rawInput: string) => Promise<void>;
  reset: () => void;
};

type ErrorMessageHolder = {
  status?: number;
  response?: {
    data?: {
      message?: string;
    };
  };
}

function hasClientErrorMessage(err: ErrorMessageHolder) {
  const status = err?.status || 0;

  return status >= 300 && status < 500 && err?.response?.data?.message;
}

function getClientErrorMessage(err: ErrorMessageHolder) {
  return String(err?.response?.data?.message);
}

export function useStarWarsRequest<T>({
                                        defaultValue,
                                        errorMessage,
                                        request
                                      }: UseStarWarsRequestOptions<T>): UseStarWarsRequestReturn<T> {
  const [ data, setData ] = useState<T>(() => defaultValue());
  const [ error, setError ] = useState<string | null>(null);
  const { isLoading, itLoads } = useLoading();

  /**
   * Executes the provided request function and updates the data state.
   */
  const runRequest = useMemo(() => async (input: string) => {
    const nextData = await request(input);
    setData(nextData);
    setError(null);
  }, [ request ]);

  /**
   * Resets the data and error state to their default values.
   */
  const reset = useCallback(() => {
    setData(defaultValue());
    setError(null);
  }, [ defaultValue ]);

  /**
   * Execute the request with input sanitization and error handling
   */
  const execute = useCallback(async (rawInput: string) => {
    const sanitizedInput = rawInput.trim();

    if (!sanitizedInput) {
      reset();

      return Promise.resolve();
    }

    try {
      return await runRequest(sanitizedInput);
    } catch (err) {
      console.error(err);
      reset();

      if (hasClientErrorMessage(err as ErrorMessageHolder)) {
        setError(getClientErrorMessage(err as ErrorMessageHolder));

        return Promise.resolve();
      }

      setError(errorMessage);

      return Promise.resolve();
    }
  }, [ runRequest, reset, errorMessage ]);

  return {
    data,
    error,
    isLoading,
    execute: itLoads(execute),
    reset
  };
}

