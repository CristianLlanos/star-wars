import { useEffect, useMemo } from 'react';
import { SubmitHandler, useForm } from 'react-hook-form';
import { zodResolver } from "@hookform/resolvers/zod";
import debounce from 'lodash.debounce';

import { useLoading } from '@/hooks/useLoading';
import { SearchCategory, SearchField, type SearchForm, SearchSchema } from '@/forms/SearchForm';

const DEBOUNCE_WAIT = 500;

export type SearchFormSectionProps = {
  onSubmit: SubmitHandler<SearchForm>;
  category?: SearchCategory;
  onCategoryChange?: (category: SearchCategory) => void;
};

const placeholders: Record<SearchCategory, string> = {
  [ SearchCategory.PEOPLE ]: 'e.g. Chewbacca, Yoda, Boba Fett',
  [ SearchCategory.MOVIES ]: 'e.g. A New Hope, The Last Jedi'
};

export function SearchFormSection({
                                    onSubmit,
                                    category = SearchCategory.PEOPLE,
                                    onCategoryChange
                                  }: SearchFormSectionProps) {
  /**
   * Search Form
   */
  const { handleSubmit, register, watch, setValue, formState: { errors } } = useForm<SearchForm>({
    resolver: zodResolver(SearchSchema),
    defaultValues: {
      category,
      query: ''
    },
  });

  /**
   * Keep form category in sync with parent when it changes externally
   */
  useEffect(() => {
    setValue(SearchField.CATEGORY, category, { shouldDirty: false, shouldTouch: false, shouldValidate: false });
  }, [ category, setValue ]);

  /**
   * Handle dynamic placeholder and notify parent of category changes
   */
  const selectedCategory = watch(SearchField.CATEGORY);

  useEffect(() => {
    if (onCategoryChange) {
      onCategoryChange(selectedCategory);
    }
  }, [ selectedCategory, onCategoryChange ]);

  const searchPlaceholder = useMemo(() => (
    placeholders[ selectedCategory ] ?? placeholders[ SearchCategory.PEOPLE ]
  ), [ selectedCategory ]);

  /**
   * Handle debounced search on query change and loading state
   */
  const queryValue = watch(SearchField.QUERY);
  const { isLoading, itLoads } = useLoading();

  const onSearch = useMemo(() => handleSubmit(itLoads(onSubmit)), [ handleSubmit, onSubmit, itLoads ]);

  const debouncedSearch = useMemo(() => debounce(onSearch, DEBOUNCE_WAIT), [ onSearch ]);

  useEffect(() => {
    if (!queryValue?.trim()) {
      debouncedSearch.cancel();
      return;
    }

    debouncedSearch();

    return () => {
      debouncedSearch.cancel();
    };
  }, [ queryValue, debouncedSearch, selectedCategory ]);

  return (
    <section aria-labelledby="search-heading" className="card card--search">
      <h2 id="search-heading" className="search-heading">What are you searching for?</h2>
      <form className="search-form" onSubmit={onSearch} noValidate>
        <fieldset className="search-options">
          <label className="radio-option">
            <input
              type="radio"
              value={SearchCategory.PEOPLE}
              {...register(SearchField.CATEGORY)}
            />
            People
          </label>
          <label className="radio-option">
            <input
              type="radio"
              value={SearchCategory.MOVIES}
              {...register(SearchField.CATEGORY)}
            />
            Movies
          </label>
        </fieldset>

        <input
          className={`search-input${errors?.query ? ' search-input--invalid' : ''}`}
          type="search"
          placeholder={searchPlaceholder}
          {...register(SearchField.QUERY)}
          aria-invalid={!!errors?.query}
          aria-describedby={errors?.query ? 'query-error' : undefined}
        />
        {errors?.query && (
          <p className="error-message">
            {errors.query.message}
          </p>
        )}

        <button
          type="submit"
          className="button"
          disabled={isLoading}
        >
          {isLoading ? 'SEARCHING...' : 'SEARCH'}
        </button>
      </form>
    </section>
  );
}
