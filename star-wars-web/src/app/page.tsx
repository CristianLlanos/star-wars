'use client';

import { useState } from 'react';
import { SearchCategory, SearchForm } from '@/forms/SearchForm';
import { SearchFormSection } from '@/components/SearchFormSection';
import { ResultsSection } from '@/components/ResultsSection';
import { usePeopleSearchByName } from '@/api/usePeopleSearchByName';
import { useMoviesSearchByTitle } from "@/api/useMoviesSearchByTitle";

export default function Home() {
  const {
    results: resultsPeople,
    error: errorPeople,
    isLoading: isLoadingPeople,
    searchPeople
  } = usePeopleSearchByName();

  const {
    results: resultsMovies,
    error: errorMovies,
    isLoading: isLoadingMovies,
    searchMovies
  } = useMoviesSearchByTitle();

  const [ category, setCategory ] = useState<SearchCategory>(SearchCategory.PEOPLE);

  const doSearch = async (data: SearchForm) => {
    if (data.category === SearchCategory.MOVIES) {
      await searchMovies(data.query);
    }

    if (data.category === SearchCategory.PEOPLE) {
      await searchPeople(data.query);
    }
  };

  return (
    <>
      <SearchFormSection
        onSubmit={doSearch}
        category={category}
        onCategoryChange={setCategory}
      />

      {category === SearchCategory.PEOPLE ? (
        <ResultsSection
          searchResults={resultsPeople}
          errorMessage={errorPeople}
          isLoading={isLoadingPeople}
          category={category}
        />
      ) : (
        <ResultsSection
          searchResults={resultsMovies}
          errorMessage={errorMovies}
          isLoading={isLoadingMovies}
          category={category}
        />
      )}
    </>
  );
}
