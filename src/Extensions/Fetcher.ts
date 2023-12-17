import AppVariables from '../AppVariables';
import Movie from '../models/Movie';
import type { Result } from '../models/TMDB';
import type Root from '../models/TMDB';

/**
 * Fait une requête à l'API pour récupérer les données de la base de données
 * @param sql La requête SQL à exécuter
 * @returns Les données de la requête
 */
export async function FetchDB(sql: string, tableName: string = ''): Promise<any> {
	const url = AppVariables.SQL_API_URL + sql;

	const res = await fetch(url);

	const results: [] = (await res.json()).results;

	// Si la requête SQL contient le nom de la table 'BestMoviesNetflix' alors
	// convertis les résultats en objet Movie
	if (tableName.toLowerCase() === 'bestmoviesnetflix') {
		let movies: Movie[] = [];

		results.map((mov: any) => {
			movies.push(
				new Movie(
					'',
					mov.TITLE,
					-1,
					mov.RELEASE_YEAR,
					mov.SCORE,
					mov.NUMBER_OF_VOTES,
					mov.MAIN_PRODUCTION,
					mov.DURATION,
					mov.MAIN_GENRE,
					'',
					'',
					''
				)
			);
		});

		return movies;
	} else if (tableName.toLowerCase() === 'titles') {
		let movies: Movie[] = [];

		results.map((mov: any) => {
			movies.push(
				new Movie(
					mov.description,
					mov.title,
					-1,
					mov.release_year,
					-1,
					-1,
					'',
					mov.runtime,
					'',
					mov.genres,
					mov.production_countries,
					mov.age_certification
				)
			);
		});

		return movies;
	}

	return results;
}

export async function GetPosterPath(title: string, release_date: string): Promise<string> {
	const url = AppVariables.TMDB_API_URL + encodeURIComponent(title);

	const res = await fetch(url);

	try {
		const json = await res.json();

		if (json.length === 0) return 'no_poster.png';
		return 'https://image.tmdb.org/t/p/original' + json;
	} catch {
		return 'no_poster.png';
	}
}
