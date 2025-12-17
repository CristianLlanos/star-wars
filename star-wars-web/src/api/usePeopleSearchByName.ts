import { StarWars } from '@/api/StarWars';
import { useStarWarsRequest } from '@/api/useStarWarsRequest';
import { Person } from "@/api/types";

const ERROR_MESSAGE = 'Unable to fetch people right now. Please try again.';

export function usePeopleSearchByName() {
  const { data, error, isLoading, execute } = useStarWarsRequest<Person[]>({
    defaultValue: () => [],
    errorMessage: ERROR_MESSAGE,
    request: (query) => StarWars.searchPeopleByName(query)
  });

  return {
    results: data,
    error,
    isLoading,
    searchPeople: execute
  };
}
