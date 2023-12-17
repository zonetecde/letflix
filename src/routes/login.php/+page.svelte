<script lang="ts">
	import { createEventDispatcher } from 'svelte';

	const dispatcher = createEventDispatcher();

	let anim = false;
	let password: boolean = false;
	let wrong: boolean = false;

	const handleLogin = (kid: boolean = false) => {
		if (kid) {
			password = true;
			return;
		}

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
		window.location.href = '/page1.php';
	};

	function checkPassword(event: Event & { currentTarget: EventTarget & HTMLInputElement }) {
		// check password
		const password = '2024';
		let enteredPassword = '';
		for (let i = 0; i < 4; i++) {
			const inputElement = document.getElementById(`input-${i}`) as HTMLInputElement;
			enteredPassword += inputElement ? inputElement.value : '';
		}

		if (enteredPassword.length === 4 && enteredPassword !== password) {
			wrong = true;
		} else if (enteredPassword === password) {
			handleLogin();
		}
	}

	function nextField(
		e: KeyboardEvent & { currentTarget: EventTarget & HTMLInputElement },
		i: number
	) {
		if (e.key === 'Backspace') {
			wrong = false;
			const prevInput = document.getElementById(`input-${i - 1}`);
			if (prevInput) {
				prevInput.focus();
			}
		} else if (e.key.length === 1) {
			const nextInput = document.getElementById(`input-${i + 1}`);
			if (nextInput) {
				nextInput.focus();
			}
		}
	}
</script>

<div class="w-full h-full bg-[#141414] flex items-center justify-center flex-col overflow-hidden">
	{#if anim}
		<video autoplay class="w-full" id="video-anim" on:ended={handleAnimEnd}>
			<track kind="captions" />
			<source src="todom.mp4" type="video/mp4" />
		</video>
	{:else if password}
		<button
			on:click={() => {
				wrong = false;

				password = false;
			}}
			class="w-10 h-10 absolute left-3 top-3 cursor-pointer"
		>
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="gray"
			>
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"
				/>
			</svg>
		</button>

		<h1 class="text-2xl font-bold mb-5">Votre compte est limité.</h1>
		<h1 class="text-4xl font-bold mb-20">Mot de passe du tuteur :</h1>

		<div class="flex flex-row mb-20">
			{#each Array(4) as _, i}
				<input
					type=""
					id={`input-${i}`}
					maxlength="1"
					on:keyup={(e) => nextField(e, i)}
					class={'w-24 h-24 text-center text-4xl border-2 bg-gray-600 text-white border-[#1F1F1F] rounded-md mx-2 ' +
						(wrong ? 'border-red-800 bg-red-400 outline-none' : '')}
					on:input={checkPassword}
				/>
			{/each}
		</div>

		{#if wrong}
			<p class="text-red-400 mb-5">Mot de passe incorrect.</p>
			<small class="text-gray-400 italic">Indice: l'année prochaine</small>
		{/if}
	{:else}
		<h1 class="text-4xl font-bold mb-20">Qui regarde ?</h1>

		<div class="w-10/12 flex items-center justify-center gap-x-3 mb-20">
			<button
				class="flex flex-col hover:scale-110 duration-150 cursor-pointer relative"
				on:click={() => handleLogin(true)}
			>
				<img src="pp_niedercorn.jpg" alt="M. Niedercon" class="w-48 border-4 border-[#1F1F1F]" />
				<p class="my-2 text-[#636262] w-full text-center">M. Niedercon</p>

				<sm class="absolute -bottom-5 text-[#535353] left-0 right-0 italic">Compte enfant</sm>
			</button>
			<button
				class="flex flex-col text-center hover:scale-110 duration-150 cursor-pointer"
				on:click={() => handleLogin()}
			>
				<img src="pp_boyaval.jpg" alt="M. Boyaval" class="w-48 border-4 border-[#1F1F1F]" />
				<p class="my-2 text-[#636262] w-full text-center">M. Boyaval</p>
			</button>
		</div>

		<i class="text-white opacity-40"
			>Pour une meilleure expérience, appuyez sur F11 (plein écran)
		</i>
	{/if}
</div>
