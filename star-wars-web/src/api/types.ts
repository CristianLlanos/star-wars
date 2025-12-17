export type Movie = {
  id: number;
  opening_crawl: string;
  title: string;
  characters?: Person[];
}

export type Person = {
  id: string;
  name: string,
  gender: string,
  skin_color: string,
  hair_color: string,
  height: string,
  eye_color: string,
  mass: string,
  birth_year: string,
  edited: string,
  created: string,
  movies?: Movie[];
};

export type PeopleByNameResponse = {
  data?: Person[];
};

export type PeopleByIdResponse = {
  data?: Person;
};

export type MoviesByTitleResponse = {
  data?: Movie[];
};

export type MoviesByIdResponse = {
  data?: Movie;
};

export type StatsResponse = {
  top_movie_queries_percentage?: Record<string, number>;
  top_person_queries_percentage?: Record<string, number>;
  average_request_time_ms?: Record<string, number>;
  popular_hours_percentage?: Record<string, number>;
}
