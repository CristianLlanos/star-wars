import { StarWars } from '@/api/StarWars';
import { useStarWarsRequest } from '@/api/useStarWarsRequest';
import { StatsResponse } from '@/api/types';

const ERROR_MESSAGE = 'Unable to fetch stats right now. Please try again.';

export function useStats() {
  const { data, error, isLoading, execute, reset } = useStarWarsRequest<StatsResponse>({
    defaultValue: () => ({}),
    errorMessage: ERROR_MESSAGE,
    // Stats endpoint doesn't require an input, we ignore the argument
    request: async () => await StarWars.getStats()
  });

  return {
    stats: data,
    error,
    isLoading,
    fetchStats: () => execute('stats'),
    reset
  };
}
