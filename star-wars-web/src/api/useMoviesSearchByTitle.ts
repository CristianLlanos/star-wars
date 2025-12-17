import { StarWars } from '@/api/StarWars';
import { useStarWarsRequest } from '@/api/useStarWarsRequest';
import { Movie } from '@/api/types';

const ERROR_MESSAGE = 'Unable to fetch movies right now. Please try again.';

export function useMoviesSearchByTitle() {
  const { data, error, isLoading, execute } = useStarWarsRequest<Movie[]>({
    defaultValue: () => [],
    errorMessage: ERROR_MESSAGE,
    request: (query) => StarWars.searchFilmsByName(query)
  });

  return {
    results: data,
    error,
    isLoading,
    searchMovies: execute
  };
}

