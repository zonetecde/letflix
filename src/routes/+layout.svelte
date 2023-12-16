<script lang="ts">
	import { afterUpdate, onMount } from 'svelte';
	import '../app.css';
	import { modal, watchMovie } from '../models/Store';
	import { fade } from 'svelte/transition';

	let onLoginScreen: boolean = false;

	afterUpdate(() => {
		const page = window.location.pathname.split('/')[1];
		if (page !== 'login.php' && page !== '') {
			onLoginScreen = false;
		} else {
			onLoginScreen = true;
		}
	});

	function goToMain() {
		window.location.href = '/';
	}

	let modalText = '';
	modal.subscribe((value) => {
		modalText = value;
	});
	let movieScreen = false;
	watchMovie.subscribe((value) => {
		movieScreen = value;
	});
</script>

{#if onLoginScreen}
	<div class="w-screen h-screen">
		<slot />
	</div>
{:else}
	<div class="h-screen w-screen">
		<nav
			class="bg-[#512727] h-12 md:h-20 flex flex-row relative items-center px-5 border-b-2 border-red-800 outline-b"
		>
			<div
				class="absolute left-0 right-0 px-10 py-1 h-full flex flex-row items-center justify-center gap-4 bg-gradient-to-r from-[#c3adc500] via-[#ae2833] to-[#c3adc500]"
			>
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
				<img
					src="letflix-white.png"
					alt="Logo du site"
					class="h-full object-contain cursor-pointer"
					on:click={goToMain}
				/>
				<!-- svelte-ignore a11y-click-events-have-key-events -->
				<!-- svelte-ignore a11y-no-noninteractive-element-interactions -->
				<img
					src="github.png"
					alt="GitHub logo"
					class="absolute opacity-60 right-2 w-8 md:w-24 cursor-pointer"
					on:click={() => window.open('https://github.com/zonetecde/letflix')}
				/>
			</div>
		</nav>

		<div class="h-full -mt-12 pt-12 md:-mt-20 md:pt-20">
			<slot />

			{#if modalText !== ''}
				<div
					transition:fade
					class="bg-black bg-opacity-60 absolute inset-0 flex items-center justify-center"
				>
					<div
						class="bg-red-100 w-8/12 h-2/6 rounded-3xl border-4 border-black shadow-xl shadow-red-100 flex items-center justify-center relative flex flex-col"
					>
						<!-- Close -->
						<button
							class="absolute top-0 right-0 w-10 h-10 bg-red-600 border-l-4 border-b-4 border-black pt-1 pr-1 text-white text-xl font-bold flex items-center justify-center rounded-tr-2xl"
							on:click={() => modal.set('')}>X</button
						>
						<p class="text-black lg:text-3xl md:text-2xl text-xl md:px-32 text-center">
							{@html modalText}
						</p>

						{#if modalText.includes('XILON')}
							<button
								class="w-64 h-16 bg-red-800 rounded-lg text-lg absolute -bottom-18 mb-5 duration-150 xilon-button"
								on:click={() =>
									modal.set(
										"Vous avez souscrit à l'abonnement <b>urgence capillaire</b>.</br>Nouveau délai de livraison estimé à 24 heures."
									)}>Annuler la commande</button
							>
						{/if}
					</div>
				</div>{/if}

			{#if movieScreen}
				<div class="absolute bottom-0 left-0 right-0 top-0 fullscreen">
					<iframe
						class="w-full h-full"
						src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&controls=0&loop=1"
						allow="autoplay; encrypted-media"
						allowfullscreen
						title="Trailer"
					></iframe>

					<button
						class="absolute top-3 right-3 w-10 h-10 bg-red-600 hover:bg-red-700 hover:scale-110 duration-150 border-4 border-black text-white text-xl font-bold flex items-center justify-center"
						on:click={() => watchMovie.set(false)}>X</button
					>
				</div>
			{/if}
		</div>
	</div>
{/if}
