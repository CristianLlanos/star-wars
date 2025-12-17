import { z } from 'zod';

export enum SearchCategory {
  PEOPLE = 'people',
  MOVIES = 'movies'
}

export enum SearchField {
  CATEGORY = 'category',
  QUERY = 'query'
}

export const SearchSchema = z.object({
  [ SearchField.CATEGORY ]: z.enum([ SearchCategory.PEOPLE, SearchCategory.MOVIES ], {
    errorMap: () => ({ message: 'Please choose People or Movies.' })
  }),
  [ SearchField.QUERY ]: z.string().trim().min(2, 'Enter at least 2 characters.').max(80, 'Keep it under 80 characters.')
});

export type SearchForm = z.infer<typeof SearchSchema>;
