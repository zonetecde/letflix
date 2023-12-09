<script lang="ts">
	import Carrousel from './components/FilmsShower.svelte';
	import Login from './components/Login.svelte';
	import Nombre from './components/Nombre.svelte';
	import Resume from './components/Resume.svelte';
	import TextShower from './components/TextShower.svelte';

	let loggedIn: boolean = false;
</script>

{#if !loggedIn}
	<Login on:loggedIn={() => (loggedIn = true)} />
{:else}
	<div class="w-full h-full bg-[#532727] text-black p-4 overflow-y-auto scrollbar">
		<h1 class="text-4xl font-bold underline underline-offset-4 mb-3 text-white">Fiche 1</h1>
		<Carrousel
			sql="SELECT * FROM 'topratedmovies' where title like 'Star Wars%';"
			sectionTitle="Nos films Star Wars"
			tableName="topratedmovies"
		/>
		<br />

		<Carrousel
			sql="SELECT * FROM 'bestmoviesnetflix' where RELEASE_YEAR < 2000 and score > 8.0;"
			sectionTitle="Les films avant 2000 avec un score supérieur à 8/10"
			tableName="bestmoviesnetflix"
		/>

		<br />

		<TextShower
			sectionTitle="Tout les genres parmis les meilleurs séries... :"
			sql="SELECT DISTINCT MAIN_GENRE as _text FROM 'bestshowsnetflix';"
			tableName="text"
		/>

		<br />

		<!-- <FilmsMieuxNotes
		sql="SELECT * FROM topratedmovies ORDER BY VoteAverage desc LIMIT 15;"
		sectionTitle="Nos films les mieux notés..."
		tableName="topratedmovies"
	/>

	<br /> -->

		<Resume
			sql="SELECT * FROM 'topratedmovies' where Title like '%Spider-Man%' ORDER BY VoteAverage desc LIMIT 1;"
			sectionTitle="La description du film Spider-Man le mieux noté :"
			tableName="topratedmovies"
		/>

		<h1 class="text-4xl font-bold underline underline-offset-4 mt-5 mb-3 text-white">Fiche 2</h1>

		<Nombre
			sql="SELECT sum(votecount) as _count FROM 'topratedmovies';
		"
			sectionTitle="Le nombre total de vote dans la table topratedmovies"
		/>

		<br />

		<Nombre
			sql="SELECT count(*) as _count FROM bestshowsnetflix where SEASONS > 5
		"
			sectionTitle="Le nombre de série qui ont plus de 5 saisons"
		/>
		<br />

		<Nombre
			sql="SELECT avg(DURATION) as _count FROM bestmoviesnetflix where DURATION >= (select DURATION from bestmoviesnetflix where TITLE = 'Steve Jobs');
		"
			sectionTitle="La durée moyenne des films qui durent plus longtemps que le film 'Steve Jobs'"
			roundResult={false}
		/>

		<br />

		<Resume
			sql="SELECT * from topratedmovies where Title like '%Die Hard%' order by Popularity LIMIT 1 OFFSET 2;"
			sectionTitle="La description du film à la popularité médiane Die Hard"
			tableName="topratedmovies"
		/>

		<h1 class="text-4xl font-bold underline underline-offset-4 mt-5 mb-3 text-white">Fiche 3</h1>

		<Carrousel
			sectionTitle="Les titres des films où Robert De Niro a joué :"
			sql="SELECT titles.* FROM titles, credits where titles.id = credits.id and credits.name = 'Robert De Niro';"
			tableName="titles"
		/>

		<br />
		<Carrousel
			sectionTitle="Les titres des films où Johnny Depp a joué et interdit au moins de 17 ans :"
			sql="SELECT titles.* FROM titles, credits where titles.id = credits.id and credits.name = 'Johnny Depp' and titles.age_certification = 'R';"
			tableName="titles"
		/>

		<br />

		<Nombre
			sql="SELECT titles.release_year as _count FROM titles, credits where titles.id = credits.id and credits.name = 'Clint Eastwood' and credits.character = 'Harry'
		"
			sectionTitle="L'année de sortie du film où apparait Harry, joué par Clint Eastwood"
		/>

		<br />

		<Carrousel
			sectionTitle="Les titres communs classés par popularité croissante entre Titles et TopRatedMovies :"
			sql="SELECT topratedmovies.* FROM titles, topratedmovies where titles.title = topratedmovies.title order by topratedmovies.popularity limit 10;"
			tableName="topratedmovies"
		/>
	</div>
{/if}
