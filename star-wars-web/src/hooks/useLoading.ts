import { useCallback, useState } from 'react';

export function useLoading() {
  const [ isLoading, setIsLoading ] = useState<boolean>(false);

  const itLoads = useCallback(<TResult, TArgs extends unknown[]>(task: (...args: TArgs) => Promise<TResult> | TResult) => {
    return async (...args: TArgs): Promise<TResult> => {
      setIsLoading(true);

      try {
        return await task(...args);
      } finally {
        setIsLoading(false);
      }
    };
  }, []);

  return { isLoading, itLoads };
}

