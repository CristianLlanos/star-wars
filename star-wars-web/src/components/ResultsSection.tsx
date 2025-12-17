import Link from 'next/link';
import { Movie, Person } from "@/api/types";
import { SearchCategory } from "@/forms/SearchForm";

type ResultsSectionProps = {
  isLoading: boolean;
  errorMessage: string | null;
  searchResults: Person[] | Movie[];
  category: SearchCategory;
};

export function ResultsSection({ isLoading, errorMessage, searchResults, category }: ResultsSectionProps) {
  return (
    <section aria-labelledby="results-heading" className="card card--results">
      <h2 id="results-heading" className="heading">Results</h2>
      <hr className="divider"/>
      <div className="results-container">
        {isLoading && (
          <div className="no-results">Searching...</div>
        )}

        {!isLoading && errorMessage && (
          <div className="no-results">
            {errorMessage}
          </div>
        )}

        {!isLoading && !errorMessage && searchResults.length === 0 && (
          <div className="no-results">
            There are zero matches. <br/> Use the form to search for People or Movies.
          </div>
        )}

        {!isLoading && !errorMessage && searchResults.length > 0 && (
          <ul className="results-list">
            {searchResults.map((result) => (
              <li key={result.id} className="result-item">
                <div className="result-item__info">
                  <h3 className="result-name">
                    {category === SearchCategory.PEOPLE ? (result as Person).name : (result as Movie).title}
                  </h3>
                  <Link className="button"
                        href={category === SearchCategory.PEOPLE ? `/people/${result.id}` : `/movies/${result.id}`}>
                    SEE DETAILS
                  </Link>
                </div>
                <hr className="divider"/>
              </li>
            ))}
          </ul>
        )}
      </div>
    </section>
  );
}
