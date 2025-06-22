// public/js/welcome.js
class WelcomePage {
    constructor() {
        this.currentSearch = {
            posisi: "",
            lokasi: "",
            isSearching: false,
        };
        this.routes = window.AppConfig ? window.AppConfig.routes : {};
        this.config = window.AppConfig || {};
        this.init();
    }

    // Initialize the application
    init() {
        this.setupCSRF();
        this.bindEvents();
        this.setupNavbarScroll();
    }

    // Set routes from Laravel (will be called from blade template)
    setRoutes(routes) {
        this.routes = { ...this.routes, ...routes };
    }

    // Setup CSRF token for AJAX requests
    setupCSRF() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }

    // Bind all event listeners
    bindEvents() {
        // Search form submission
        $("#searchForm").on("submit", (e) => {
            e.preventDefault();
            this.performSearch(1);
        });

        // Reset search button
        $("#resetSearch").on("click", () => {
            this.resetSearch();
        });

        // Pagination clicks (using event delegation)
        $(document).on("click", ".pagination a", (e) => {
            e.preventDefault();
            const url = $(e.currentTarget).attr("href");
            const page = this.getPageFromUrl(url);

            if (this.currentSearch.isSearching) {
                this.performSearch(page);
            } else {
                this.loadPage(page);
            }
        });

        // Live search with debounce
        let searchTimeout;
        $("#posisiInput, #lokasiInput").on("input", () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const posisi = $("#posisiInput").val();
                const lokasi = $("#lokasiInput").val();
                const minLength = this.config.search?.minSearchLength || 2;

                if (posisi.length > minLength || lokasi.length > minLength) {
                    this.performSearch(1);
                }
            }, this.config.search?.debounceDelay || 500);
        });
    }

    // Setup navbar scroll behavior
    setupNavbarScroll() {
        window.addEventListener("scroll", () => {
            const navbar = document.querySelector(".navbar");
            const whiteSection = document.querySelector(".search-section");

            if (!navbar || !whiteSection) return;

            const scrollY = window.scrollY + navbar.offsetHeight;
            const sectionTop = whiteSection.offsetTop;
            const sectionHeight = whiteSection.offsetHeight;
            const buffer = 1400;

            const sectionBottom = sectionTop + sectionHeight + buffer;

            if (scrollY >= sectionTop && scrollY <= sectionBottom) {
                navbar.classList.add("navbar-light-scroll", "navbar-light");
                navbar.classList.remove("navbar-dark");
            } else {
                navbar.classList.remove("navbar-light-scroll", "navbar-light");
                navbar.classList.add("navbar-dark");
            }
        });
    }

    // Perform search with AJAX
    performSearch(page = 1) {
        const posisi = $("#posisiInput").val();
        const lokasi = $("#lokasiInput").val();

        // Update current search state
        this.currentSearch = {
            posisi: posisi,
            lokasi: lokasi,
            isSearching: true,
        };

        this.showLoading();

        $.ajax({
            url: this.routes.ajaxSearch,
            method: "POST",
            data: {
                posisi: posisi,
                lokasi: lokasi,
                page: page,
            },
            success: (response) => {
                this.hideLoading();
                if (response.success) {
                    this.displayResults(response.data);
                    this.displayPagination(response.pagination);
                    this.updateSearchInfo(
                        posisi,
                        lokasi,
                        response.pagination.total
                    );
                    this.smoothScrollToResults();
                }
            },
            error: (xhr, status, error) => {
                this.hideLoading();
                console.error("Error:", error);
                const errorMsg =
                    this.config.messages?.searchError ||
                    "Terjadi kesalahan saat melakukan pencarian. Silakan coba lagi.";
                this.showErrorMessage(errorMsg);
            },
        });
    }

    // Load page without search
    loadPage(page = 1) {
        this.showLoading();

        $.ajax({
            url: this.routes.ajaxPaginate,
            method: "GET",
            data: { page: page },
            success: (response) => {
                this.hideLoading();
                if (response.success) {
                    this.displayResults(response.data);
                    this.displayPagination(response.pagination);
                    this.smoothScrollToResults();
                }
            },
            error: (xhr, status, error) => {
                this.hideLoading();
                console.error("Error:", error);
                this.showErrorMessage(
                    "Terjadi kesalahan saat memuat halaman. Silakan coba lagi."
                );
            },
        });
    }

    // Reset search functionality
    resetSearch() {
        $("#posisiInput").val("");
        $("#lokasiInput").val("");
        $("#section-title").text("Lowongan Magang Terbaru");
        $("#search-count").addClass("d-none");
        this.currentSearch = { posisi: "", lokasi: "", isSearching: false };
        this.loadInitialData();
    }

    // Display search results
    displayResults(data) {
        const container = $("#magang-container");
        container.empty();

        if (data.length === 0) {
            container.html(`
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada lowongan magang yang sesuai dengan pencarian Anda.
                        <br><small>Coba gunakan kata kunci yang berbeda atau kosongkan filter.</small>
                    </div>
                </div>
            `);
            return;
        }

        data.forEach((item) => {
            const logoHtml = item.perusahaan.logo
                ? `<img src="/storage/${item.perusahaan.logo}" alt="${item.perusahaan.nama_perusahaan}" class="img-fluid rounded">`
                : item.perusahaan.nama_perusahaan.substring(0, 3);

            const cardHtml = `
                <div class="col-md-6 col-lg-4 mb-4 magang-item">
                    <div class="job-card bg-light">
                        <div class="d-flex mb-3">
                            <div class="company-logo me-3 d-flex align-items-center justify-content-center text-success">
                                ${logoHtml}
                            </div>
                            <div>
                                <h5 class="mb-1">${item.judul}</h5>
                                <p class="mb-0 text-muted">${
                                    item.perusahaan.nama_perusahaan
                                }</p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-success text-white me-2">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                ${item.lokasi}
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-clock me-1"></i>
                                ${item.kuota} posisi tersedia
                            </span>
                        </div>
                        <p class="text-muted small">${this.truncateText(
                            item.deskripsi,
                            100
                        )}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Dibuka hingga ${this.formatDate(
                                    item.tanggal_selesai
                                )}
                            </small>
                            <a href="${this.routes.magangShow.replace(
                                ":id",
                                item.id
                            )}" class="btn btn-sm btn-outline-success">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            `;
            container.append(cardHtml);
        });
    }

    // Display pagination
    displayPagination(pagination) {
        const container = $("#pagination-container");
        container.empty();

        if (pagination.last_page <= 1) {
            return;
        }

        let paginationHtml =
            '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

        // Previous button
        if (pagination.has_previous) {
            paginationHtml += `<li class="page-item">
                <a class="page-link" href="?page=${pagination.previous_page}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>`;
        } else {
            paginationHtml += `<li class="page-item disabled">
                <span class="page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </span>
            </li>`;
        }

        // Page numbers
        const startPage = Math.max(1, pagination.current_page - 2);
        const endPage = Math.min(
            pagination.last_page,
            pagination.current_page + 2
        );

        // First page
        if (startPage > 1) {
            paginationHtml += `<li class="page-item">
                <a class="page-link" href="?page=1">1</a>
            </li>`;
            if (startPage > 2) {
                paginationHtml += `<li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>`;
            }
        }

        // Page range
        for (let i = startPage; i <= endPage; i++) {
            if (i === pagination.current_page) {
                paginationHtml += `<li class="page-item active">
                    <span class="page-link">${i}</span>
                </li>`;
            } else {
                paginationHtml += `<li class="page-item">
                    <a class="page-link" href="?page=${i}">${i}</a>
                </li>`;
            }
        }

        // Last page
        if (endPage < pagination.last_page) {
            if (endPage < pagination.last_page - 1) {
                paginationHtml += `<li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>`;
            }
            paginationHtml += `<li class="page-item">
                <a class="page-link" href="?page=${pagination.last_page}">${pagination.last_page}</a>
            </li>`;
        }

        // Next button
        if (pagination.has_next) {
            paginationHtml += `<li class="page-item">
                <a class="page-link" href="?page=${pagination.next_page}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>`;
        } else {
            paginationHtml += `<li class="page-item disabled">
                <span class="page-link" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </span>
            </li>`;
        }

        paginationHtml += "</ul></nav>";

        // Add pagination info
        paginationHtml += `<div class="text-center mt-3">
            <small class="text-muted">
                Menampilkan ${pagination.from || 0} - ${
            pagination.to || 0
        } dari ${pagination.total} hasil
            </small>
        </div>`;

        container.html(paginationHtml);
    }

    // Update search information display
    updateSearchInfo(posisi, lokasi, total) {
        let searchTerms = [];
        if (posisi) searchTerms.push(`"${posisi}"`);
        if (lokasi) searchTerms.push(`lokasi "${lokasi}"`);

        if (searchTerms.length > 0) {
            $("#section-title").text(`Hasil Pencarian:`);
            $("#search-count")
                .removeClass("d-none")
                .text(`${total} lowongan ditemukan`);
        } else {
            $("#section-title").text("Lowongan Magang Terbaru");
            $("#search-count").addClass("d-none");
        }
    }

    // Show loading indicators
    showLoading() {
        $("#loading-indicator").removeClass("d-none");
        $(".btn-text").addClass("d-none");
        $(".btn-loading").removeClass("d-none");
    }

    // Hide loading indicators
    hideLoading() {
        $("#loading-indicator").addClass("d-none");
        $(".btn-text").removeClass("d-none");
        $(".btn-loading").addClass("d-none");
    }

    // Show error message
    showErrorMessage(message) {
        const container = $("#magang-container");
        container.html(`
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    ${message}
                </div>
            </div>
        `);
    }

    // Smooth scroll to results section
    smoothScrollToResults() {
        $("html, body").animate(
            {
                scrollTop: $("#magang-section").offset().top - 100,
            },
            500
        );
    }

    // Load initial data
    loadInitialData() {
        this.loadPage(1);
    }

    // Extract page number from URL
    getPageFromUrl(url) {
        const urlParams = new URLSearchParams(url.split("?")[1]);
        return urlParams.get("page") || 1;
    }

    // Utility: Truncate text
    truncateText(text, length) {
        if (text.length <= length) return text;
        return text.substring(0, length) + "...";
    }

    // Utility: Format date
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString("id-ID", {
            day: "numeric",
            month: "short",
            year: "numeric",
        });
    }
}

// Initialize when document is ready
$(document).ready(function () {
    window.welcomePage = new WelcomePage();
});
