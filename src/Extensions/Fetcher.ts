import AppVariables from '../AppVariables';
import type { Result } from '../models/TMDB';
import type Root from '../models/TMDB';

/**
 * Fait une requête à l'API pour récupérer les données de la base de données
 * @param sql La requête SQL à exécuter
 * @returns Les données de la requête
 */
export async function FetchDB(sql: string): Promise<any> {
	const url =
		AppVariables.SQL_API_URL + 'SELECT * FROM topratedmovies ORDER BY VoteAverage desc LIMIT 15';

	const res = await fetch(url);

	return (await res.json()).results;
}

export async function FindFromTMDB(title: string, release_date: string): Promise<Result> {
	const url =
		AppVariables.TMDB_API_URL +
		encodeURIComponent(`https://api.themoviedb.org/3/search/movie?api_key=%apikey%&query=${title}`);

	const res = await fetch(url);

	console.log(url);

	const root: Root = JSON.parse(await res.json());

	return root.results[0];
}
