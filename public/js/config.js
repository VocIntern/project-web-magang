// public/js/config.js
// Configuration file for JavaScript modules

const AppConfig = {
    // API endpoints (will be overridden by Laravel routes)
    routes: {
        ajaxSearch: "/ajax/search",
        ajaxPaginate: "/ajax/paginate",
        magangShow: "/mahasiswa/magang/:id",
        liveSearch: "/ajax/live-search",
    },

    // Search configuration
    search: {
        minSearchLength: 2,
        debounceDelay: 500,
        itemsPerPage: 9,
    },

    // UI configuration
    ui: {
        scrollOffset: 100,
        animationDuration: 500,
        loadingStates: {
            searching: "Mencari...",
            loading: "Memuat...",
        },
    },

    // Messages
    messages: {
        noResults:
            "Tidak ada lowongan magang yang sesuai dengan pencarian Anda.",
        noResultsSubtext:
            "Coba gunakan kata kunci yang berbeda atau kosongkan filter.",
        searchError:
            "Terjadi kesalahan saat melakukan pencarian. Silakan coba lagi.",
        loadError: "Terjadi kesalahan saat memuat halaman. Silakan coba lagi.",
        searchPlaceholder: {
            position: "Posisi atau kata kunci",
            location: "Lokasi",
        },
    },

    // Date formatting
    dateFormat: {
        locale: "id-ID",
        options: {
            day: "numeric",
            month: "short",
            year: "numeric",
        },
    },

    // Text truncation
    textLimits: {
        description: 100,
        companyName: 3, // for initials
    },
};

// Make config globally available
if (typeof window !== "undefined") {
    window.AppConfig = AppConfig;
}
