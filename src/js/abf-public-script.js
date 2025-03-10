class BotFilter {
	constructor( params ) {
		this.counters = params.counters || [];
		this.cookieName = params.cookieName || 'abf_bot_verified';
		this.cookieTime = params.cookieTime || 365;
		this.modalText = params.modalText || 'Проверка безопасности: пожалуйста, подтвердите, что вы не робот';
		this.hasLoggedAdmin = params.hasLoggedAdmin || false;

		// Список сигнатур ботов
		this.botSignatures = [
			'APIs-Google', 'Mediapartners-Google', 'AdsBot-Google', 'Googlebot',
			'YandexBot', 'YandexMobileBot', 'YandexDirect', 'YaDirectFetcher',
			'Mail.RU_Bot', 'StackRambler', 'bingbot', 'Baiduspider',
			'facebookexternalhit', 'Twitterbot', 'LinkedInBot', 'Applebot',
			'WhatsApp', 'Slackbot', 'Pinterestbot', 'VKShare', 'Odnoklassniki'
		];

		// Список доменов для проверки реферера
		this.referrerCheck = [ 'google.', 'yandex.', 'rambler.', 'bing.com' ];
	}


	isBot() {
		const isBot = this.botSignatures.some( agent => navigator.userAgent.includes( agent ) );
		console.log( 'Is bot:', isBot );
		return isBot;
	}


	checkReferrer() {
		const referrer = document.referrer;
		const isReferrer = this.referrerCheck.some( domain => referrer.includes( domain ) );
		console.log( 'Referrer:', referrer, 'Is from search engine:', isReferrer );
		return isReferrer;
	}


	setCookie() {
		const date = new Date();
		date.setTime( date.getTime() + ( this.cookieTime * 24 * 60 * 60 * 1000 ) );
		document.cookie = `${ this.cookieName }=1; expires=${ date.toUTCString() }; path=/; Secure`;
		console.log( `Cookie "${ this.cookieName }" set` );
	}


	hasCookie() {
		const cookies = document.cookie.split( ';' );
		const has = cookies.some( cookie => cookie.trim().startsWith( `${ this.cookieName }=` ) );
		console.log( `Cookie "${ this.cookieName }" exists:`, has );
		return has;
	}


	loadScripts() {
		console.log( 'Loading scripts...' );
		this.counters.forEach( script => {
			const target = document.querySelector( script.area ) || document.head;
			const fragment = document.createRange().createContextualFragment( script.html );
			target.appendChild( fragment );
		} );
		document.dispatchEvent( new Event( 'abf-scripts-loaded' ) );
	}


	/**
	 * Показывает модальное окно через wp.template
	 */
	showModal() {
		if ( typeof wp === 'undefined' || ! wp.template ) {
			console.error( 'wp.template is not available' );
			return;
		}
		// Получаем шаблон wp.template
		const template = wp.template( 'abf-bot-check' );
		const modalHTML = template( { modalText: this.modalText } );

		// Создаем контейнер для модального окна
		const modal = document.createElement( 'div' );
		modal.innerHTML = modalHTML;

		// Добавляем модальное окно в DOM
		document.body.appendChild( modal );

		const overlay = modal.querySelector( '.abf-overlay' );
		if ( overlay ) {
			overlay.classList.add( 'is-active' );
		} else {
			console.error( 'Overlay element not found' );
			return;
		}

		// Обработчик кнопки "Я не робот"
		modal.querySelector( '.abf-verify-button' ).addEventListener( 'click', () => {
			modal.remove();
			this.setCookie();
			this.loadScripts();
		} );
	}


	init() {
		console.log( 'Initializing BotFilter...' );
		console.log( 'Has admin', this.hasLoggedAdmin );
		if ( ! this.hasCookie() && ! this.checkReferrer() && ! this.isBot() && ! this.hasLoggedAdmin ) {
			console.log( 'Conditions met. Showing modal...' );
			this.showModal();
		} else {
			console.log( 'Conditions not met. Loading scripts...' );
			this.loadScripts();
		}
	}
}


// Инициализация плагина

/*global afbScriptObject */
document.addEventListener( 'DOMContentLoaded', () => {
	const botFilter = new BotFilter( afbScriptObject );
	botFilter.init();
} );