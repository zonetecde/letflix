export default class Movie {
	Overview: string;
	Title: string;
	Popularity: number;
	ReleaseDate: string;
	VoteAverage: number;
	VoteCount: number;

	PosterImg: string = '';

	MainProduction: string;
	Duration: number;
	MainGenre: string;

	Genres: string;
	ProductionCountries: string;
	AgeCertification: string;

	constructor(
		Overview: string,
		Title: string,
		Popularity: number,
		ReleaseDate: string,
		VoteAverage: number,
		VoteCount: number,
		MainProduction: string,
		Duration: number,
		MainGenre: string,
		Genres: string,
		ProductionCountries: string,
		AgeCertification: string
	) {
		this.Overview = Overview;
		this.Title = Title;
		this.Popularity = Popularity;
		this.ReleaseDate = ReleaseDate;
		this.VoteAverage = VoteAverage;
		this.VoteCount = VoteCount;

		this.MainProduction = MainProduction;
		this.Duration = Duration;
		this.MainGenre = MainGenre;

		this.Genres = Genres;
		this.ProductionCountries = ProductionCountries;
		this.AgeCertification = AgeCertification;
	}
}
