import axios, { AxiosInstance } from 'axios';
import {
  Movie,
  MoviesByIdResponse,
  MoviesByTitleResponse,
  PeopleByIdResponse,
  PeopleByNameResponse,
  Person, StatsResponse
} from '@/api/types';

const API_BASE_URL = `${(process.env.NEXT_PUBLIC_API_BASE_URL || '').trim().replace(/\/$/, '')}/api`;
const PEOPLE_RESOURCE = '/people';
const MOVIES_RESOURCE = '/movies';
const STATS_RESOURCE = '/stats';

export class StarWarsApiClient {
  private readonly http: AxiosInstance;

  constructor(baseURL: string = API_BASE_URL) {
    this.http = axios.create({ baseURL });
  }

  async searchPeopleByName(query: string): Promise<Person[]> {
    const { data } = await this.http.get<PeopleByNameResponse>(PEOPLE_RESOURCE, {
      params: { name: query }
    });

    return Array.isArray(data.data) ? data.data : [];
  }

  async getPersonById(personId: string): Promise<Person | null> {
    const { data } = await this.http.get<PeopleByIdResponse>(`${PEOPLE_RESOURCE}/${encodeURIComponent(personId)}`);

    return data.data ?? null;
  }

  async searchFilmsByName(query: string): Promise<Movie[]> {
    const { data } = await this.http.get<MoviesByTitleResponse>(MOVIES_RESOURCE, {
      params: { title: query }
    });

    return Array.isArray(data.data) ? data.data : [];
  }

  async getMovieById(movieId: string): Promise<Movie | null> {
    const { data } = await this.http.get<MoviesByIdResponse>(`${MOVIES_RESOURCE}/${encodeURIComponent(movieId)}`);

    return data.data ?? null;
  }

  async getStats(): Promise<StatsResponse> {
    const { data } = await this.http.get<StatsResponse>(STATS_RESOURCE);

    return data ?? {};
  }
}

export const StarWars = new StarWarsApiClient();

