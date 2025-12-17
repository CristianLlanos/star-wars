"use client";

import { useEffect } from "react";
import { useParams } from "next/navigation";
import Link from "next/link";
import { useMovieById } from "@/api/useMovieById";
import "./page.css";

export default function MovieDetailPage() {
  const params = useParams<{ id: string }>();
  const id = params.id;

  const { movie, error, isLoading, fetchMovie } = useMovieById();

  useEffect(() => {
    fetchMovie(id);
  }, [ id, fetchMovie ]);

  return (
    <section aria-labelledby="movie-heading" className={`card card--movie`}>
      {isLoading && <div className="no-results">Loading...</div>}

      {!isLoading && error && <div className="no-results">{error}</div>}

      {!isLoading && !error && movie && (
        <>
          <h2 id="movie-heading" className="heading heading--lg heading--main">
            {movie.title ?? "Loading movie..."}
          </h2>

          <div className="movie-container">
            <div className="movie-section">
              <div className="heading">Opening Crawl</div>
              <hr className="divider"/>
              <p className="opening-crawl">{movie.opening_crawl}</p>
            </div>

            <div className="movie-section">
              <div className="heading">Characters</div>
              <hr className="divider"/>
              <ul className="list list--inline">
                {(movie.characters ?? []).map((character, index) => (
                  <li key={character.id} className="list__item">
                    <Link
                      href={"/people/" + character.id}
                      className="link"
                    >
                      {character.name}
                    </Link>
                    {index < (movie?.characters ?? []).length - 1 && <span>, </span>}
                  </li>
                ))}
              </ul>
            </div>
          </div>

          <div className="actions">
            <Link className="button" href={`/`}>
              BACK TO SEARCH
            </Link>
          </div>
        </>
      )}
    </section>
  );
}

