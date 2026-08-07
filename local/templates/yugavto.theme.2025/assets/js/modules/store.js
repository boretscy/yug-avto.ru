/**
 * YAppStore - Единый событиями управляемый стор приложения (Event-driven Architecture)
 * Наследуется от нативного EventTarget для реализации Pub/Sub без библиотечных зависимостей.
 */
class YAppStore extends EventTarget {
    #state = {
        city: [],
        entity: 'new',
        favorites: [],
        compare: []
    };

    constructor() {
        super();
        this.#initFromCookies();
    }

    get city() {
        return [...this.#state.city];
    }

    get entity() {
        return this.#state.entity;
    }

    get favorites() {
        return [...this.#state.favorites];
    }

    get compare() {
        return [...this.#state.compare];
    }

    /**
     * Смена типа сущности (новые / с пробегом)
     */
    setEntity(entity) {
        if (this.#state.entity === entity) return;
        this.#state.entity = entity;
        this.dispatchEvent(new CustomEvent('entity:changed', { detail: { entity } }));
    }

    /**
     * Установка выбранных городов
     */
    setCity(cityArray) {
        const newCity = Array.isArray(cityArray) ? [...new Set(cityArray)] : [];
        this.#state.city = newCity;
        this.#saveCookie('SELECTED_CITY', JSON.stringify(newCity));
        this.dispatchEvent(new CustomEvent('city:changed', { detail: { city: newCity } }));
    }

    /**
     * Добавление / удаление автомобиля из Избранного
     */
    toggleFavorite(vehicleId) {
        const id = Number(vehicleId);
        if (!id) return;

        const index = this.#state.favorites.indexOf(id);
        if (index >= 0) {
            this.#state.favorites.splice(index, 1);
        } else {
            this.#state.favorites.push(id);
        }

        this.#saveCookie('CIS_FAVORITES', this.#state.favorites);
        this.dispatchEvent(new CustomEvent('favorites:updated', {
            detail: {
                favorites: [...this.#state.favorites],
                count: this.#state.favorites.length,
                id,
                action: index >= 0 ? 'removed' : 'added'
            }
        }));
    }

    /**
     * Добавление / удаление автомобиля из Сравнения
     */
    toggleCompare(vehicleId) {
        const id = Number(vehicleId);
        if (!id) return;

        const index = this.#state.compare.indexOf(id);
        if (index >= 0) {
            this.#state.compare.splice(index, 1);
        } else {
            this.#state.compare.push(id);
        }

        this.#saveCookie('CIS_COMPARE', this.#state.compare);
        this.dispatchEvent(new CustomEvent('compare:updated', {
            detail: {
                compare: [...this.#state.compare],
                count: this.#state.compare.length,
                id,
                action: index >= 0 ? 'removed' : 'added'
            }
        }));
    }

    /**
     * Инициализация состояния из Cookie
     */
    #initFromCookies() {
        try {
            this.#state.favorites = JSON.parse(this.#getCookie('CIS_FAVORITES') || '[]');
            this.#state.compare = JSON.parse(this.#getCookie('CIS_COMPARE') || '[]');
            this.#state.city = JSON.parse(this.#getCookie('SELECTED_CITY') || '[]');
        } catch (e) {
            this.#state.favorites = [];
            this.#state.compare = [];
            this.#state.city = [];
        }
    }

    #getCookie(name) {
        const match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : null;
    }

    #saveCookie(name, val) {
        document.cookie = `${encodeURIComponent(name)}=${encodeURIComponent(JSON.stringify(val))}; path=/; max-age=${3600 * 24 * 14}`;
    }
}

// Создаем синглтон глобального стора в window.YAppStore
if (typeof window !== 'undefined') {
    window.YAppStoreInstance = window.YAppStoreInstance || new YAppStore();
    window.YAppStore = window.YAppStoreInstance;
}
