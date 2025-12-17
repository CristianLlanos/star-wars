"use client";

import { useParams } from "next/navigation";
import { usePeopleById } from "@/api/usePeopleById";
import { useEffect } from "react";
import "./page.css";
import Link from "next/link";

export default function PeopleDetailPage() {
  const params = useParams<{ id: string }>();
  const id = params.id;

  const { person, error, isLoading, fetchPerson } = usePeopleById();

  useEffect(() => {
    fetchPerson(id);
  }, [ id, fetchPerson ]);

  return (
    <section aria-labelledby="person-heading" className={`card card--person`}>
      {(isLoading) && <div className="no-results">Loading...</div>}

      {!isLoading && error && <div className="no-results">{error}</div>}

      {!isLoading && !error && person && (
        <>
          <h2 id="person-heading" className="heading heading--lg heading--main">
            {person.name ?? "Loading character..."}
          </h2>

          <div className="person-container">
            <div className="person-section">
              <div className="heading">Details</div>
              <hr className="divider"/>
              <p>Birth Year: {person.birth_year}</p>
              <p>Gender: {person.gender}</p>
              <p>Eye Color: {person.eye_color}</p>
              <p>Hair Color: {person.hair_color}</p>
              <p>Height: {person.height}</p>
              <p>Mass: {person.mass}</p>
            </div>

            <div className="person-section">
              <div className="heading">Movies</div>

              <hr className="divider"/>

              {person.movies && person.movies.length > 0 && (
                <ul className="list list--inline">
                  {person.movies.map((movie, index) => (
                    <li key={movie.id} className="list__item">
                      <Link
                        href={"/movies/" + movie.id}
                        className="link"
                      >
                        {movie.title}
                      </Link>
                      {index < person.movies.length - 1 && <span>, </span>}
                    </li>
                  ))}
                </ul>
              )}

              {person.movies && person.movies.length === 0 && (
                <div className="no-results">No movies found</div>
              )}
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
