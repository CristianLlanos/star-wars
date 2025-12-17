import { StarWars } from '@/api/StarWars';
import { useStarWarsRequest } from '@/api/useStarWarsRequest';
import { Movie } from '@/api/types';

const ERROR_MESSAGE = 'Unable to fetch information right now. Please try again.';

export function useMovieById() {
  const { data, error, isLoading, execute } = useStarWarsRequest<Movie | null>({
    defaultValue: () => null,
    errorMessage: ERROR_MESSAGE,
    request: (movieId) => StarWars.getMovieById(movieId)
  });

  return {
    movie: data,
    error,
    isLoading,
    fetchMovie: execute
  };
}

