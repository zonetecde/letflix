export default class Movie {
	Overview: string;
	Title: string;
	Popularity: number;
	ReleaseDate: string;
	VoteAverage: number;
	VoteCount: number;

	PosterImg: string = '';

	constructor(
		Overview: string,
		Title: string,
		Popularity: number,
		ReleaseDate: string,
		VoteAverage: number,
		VoteCount: number
	) {
		this.Overview = Overview;
		this.Title = Title;
		this.Popularity = Popularity;
		this.ReleaseDate = ReleaseDate;
		this.VoteAverage = VoteAverage;
		this.VoteCount = VoteCount;
	}
}
