import { StarWars } from '@/api/StarWars';
import { useStarWarsRequest } from '@/api/useStarWarsRequest';
import { Person } from "@/api/types";

const ERROR_MESSAGE = 'Unable to fetch information right now. Please try again.';

export function usePeopleById() {
  const { data, error, isLoading, execute } = useStarWarsRequest<Person | null>({
    defaultValue: () => null,
    errorMessage: ERROR_MESSAGE,
    request: (personId) => StarWars.getPersonById(personId)
  });

  return {
    person: data,
    error,
    isLoading,
    fetchPerson: execute
  };
}
