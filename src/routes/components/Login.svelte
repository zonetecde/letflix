<script lang="ts">
	import { createEventDispatcher } from 'svelte';

	const dispatcher = createEventDispatcher();

	let anim = false;

	const handleLogin = () => {
		// Joue l'anim de chargement
		anim = true;

		// Change l'opacité au fur et à mesure
		setTimeout(() => {
			opacityAnim();
		}, 1);
	};

	const opacityAnim = () => {
		const video = document.getElementById('video-anim') as HTMLVideoElement;

		if (video) {
			if (Number(video.style.opacity) >= 1) {
				video.style.opacity = '1';
				return;
			} else {
				video.style.opacity = String(Number(video.style.opacity) + 0.08);
			}

			setTimeout(() => {
				opacityAnim();
			}, 100);
		}
	};

	const handleAnimEnd = () => {
		dispatcher('loggedIn');
	};
</script>

<div class="w-full h-full bg-[#141414] flex items-center justify-center flex-col overflow-hidden">
	{#if anim}
		<video autoplay class="w-full" id="video-anim" on:ended={handleAnimEnd}>
			<source src="todom.mp4" type="video/mp4" />
		</video>
	{:else}
		<h1 class="text-4xl font-bold mb-20">Qui regarde ?</h1>

		<div class="w-10/12 flex items-center justify-center gap-x-3 mb-20">
			<button
				class="flex flex-col hover:scale-110 duration-150 cursor-pointer"
				on:click={handleLogin}
			>
				<img src="pp_niedercorn.jpg" alt="M. Niedercon" class="w-48 border-4 border-[#1F1F1F]" />
				<p class="my-2 text-[#636262] w-full text-center">M. Niedercon</p>
			</button>
			<button
				class="flex flex-col text-center hover:scale-110 duration-150 cursor-pointer"
				on:click={handleLogin}
			>
				<img src="pp_boyaval.jpg" alt="M. Boyaval" class="w-48 border-4 border-[#1F1F1F]" />
				<p class="my-2 text-[#636262] w-full text-center">M. Boyaval</p>
			</button>
		</div>
	{/if}
</div>
