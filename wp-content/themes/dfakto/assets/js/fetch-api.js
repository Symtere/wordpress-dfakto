'use strict';

class QueryApi {

    constructor(config) {

        this.config = {
            id: config && config.id,
            endpoint: config.endpoint,
            query: {
                per_page: config && config.query && config.query.per_page || 6,
                page: config && config.query && config.query.page || 1,
            },
            containerClass: config && config.containerClass || false,
            contentClass: config && config.contentClass || 'row',
            pager: config && ( Boolean(config.pager) || undefined == config.pager) ? true : false,
            paginate: {
                type: config && config.paginate && config.paginate.type || 'pagination',
                pagination: {
                    arrows: config && config.paginate && config.paginate.pagination && ( Boolean(config.paginate.pagination.arrows) || undefined == config.paginate.pagination.arrows) ? true : false,
                    next: config && config.paginate && config.paginate.pagination && config.paginate.pagination.next || 'Précédent',
                    prev: config && config.paginate && config.paginate.pagination && config.paginate.pagination.prev || 'Suivant',
                },
                loadmore: {
                    more: config && config.paginate && config.paginate.loadmore && config.paginate.loadmore.more || 'Voir plus',
                    spinner: config && config.paginate && config.paginate.loadmore && config.paginate.loadmore.spinner || `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`,
                    loading: config && config.paginate && config.paginate.loadmore && config.paginate.loadmore.loading || 'Chargement...',
                    btnClassName: config && config.paginate && config.paginate.loadmore && config.paginate.loadmore.btnClassName || 'btn-primary',
                },
            },
            skeleton: {
                disable: config && config.skeleton && Boolean(config.skeleton.disable) || false,
                nbItems: config && config.skeleton && config.skeleton.nbItems || '',
                className: config && config.skeleton && config.skeleton.className || 'skeletons-list row',
                template: config && config.skeleton && config.skeleton.template || `
                    <div class="skeleton-card col-sm-4">
                        <div class="ske-img primary-light-loading"></div>
                        <div class="ske-title gray-loading"></div>
                        <div class="ske-sub-title col-8 gray-loading"></div>
                    </div>
                `,
            },
            selectors: {
                container: `#${config.id}`,
                content: `#${config.id} .content-area`,
                pagination: `#${config.id} .pagination-area`,
                loadmoreBtn: `#${config.id} .btn-load-more`,
                informations: `#${config.id} .informations-area`,
                filters: `#${config.id} .filters-area`,
                filter: `#${config.id} .filter-by`,
                search: `#${config.id} .search-area`,
                searchForm: `#${config.id} .search-area form`,
                searchBtn: `#${config.id} .search-area button`,
                searchInput: `#${config.id} .search-area input`,
                skeleton: `#${config.id} .skeleton-area`,
                skeletonList: `#${config.id} .skeletons-list`,
                skeletonTpl: `#${config.id} .skeleton-template`,
            },
            messages: {
                item: config && config.messages && config.messages.item || "contenu",
                empty: config && config.messages && config.messages.empty || "Aucun contenu n'est disponible avec les critères sélectionnés",
                error: config && config.messages && config.messages.error || "Chargement impossible, une erreur est survenue",
                loading: config && config.messages && config.messages.loading || "Chargement en cours...",
                results: config && config.messages && config.messages.results || "résultat",
            },
            debug: config && Boolean(config.debug) || false,
        };

        this.init();
    }

    init() {

        if ( !this.config.id ) {
            return;
        }

        if ( this.config.debug ) {
            console.log(this.config);
        }

        const appContainer = document.getElementById(this.config.id);
        if ( null !== appContainer && '' != this.config.containerClass ) {
            let containerClasses = this.config.containerClass.split(' ');
            appContainer.classList.add(...containerClasses);
        }

        const contentArea = document.querySelector(this.config.selectors.content);
        if ( null !== contentArea ) {

            if ( '' != this.config.contentClass ) {
                let contentClasses = this.config.contentClass.split(' ');
                contentArea.classList.add(...contentClasses);
            }

            contentArea.insertAdjacentHTML('beforebegin',`<div class="informations-area"></div>`);
            contentArea.insertAdjacentHTML('afterend',`<div class="pagination-area"></div>`);

            if ( !this.config.skeleton.disable ) {

                const skeletons = `
                    <div class="skeleton-area">
                        <div class="${this.config.skeleton.className}"></div>
                    </div>
                    <template class="skeleton-template">${this.config.skeleton.template}</template>
                `;

                contentArea.insertAdjacentHTML('afterend',skeletons);

                const items = this.config.skeleton.nbItems || this.config.query.per_page;
                const skeletonArea = document.querySelector(this.config.selectors.skeleton);

                if ( null !== skeletonArea ) {
                    const skeletonTemplate = document.querySelector(this.config.selectors.skeletonTpl);
                    const skeParent = document.querySelector(`${this.config.selectors.skeleton} > div`);

                    for (let i = 0; i < items; i++) {
                        skeParent.append(skeletonTemplate.content.cloneNode(true));
                    }
                }
            }
        }

        const paginationArea = document.querySelector(`${this.config.selectors.pagination}`);
        if ( null !== paginationArea ) {
            paginationArea.classList.add(`${this.config.paginate.type}-pagination`);

            if ( this.config.paginate.type === 'pagination' && !this.config.paginate.pagination.arrows ) {
                paginationArea.classList.add('basic-pagination');
            }

            if ( this.config.paginate.type === 'loadmore' ) {
                const loadmoreBtnHtml = `<button class="btn ${this.config.paginate.loadmore.btnClassName} btn-load-more d-none"><span>${this.config.paginate.loadmore.more}</span></button>`;
                document.querySelector(`${this.config.selectors.pagination}`).innerHTML = loadmoreBtnHtml;
                this.loadmore();
            }
        }

        this.getDatas();
        this.filters();
        this.search();
    }

    url(params = this.config.query) {
        const query = Object.keys(params).map(key => key + '=' + params[key]).join('&').toString();
        const appId = this.config.debug ? `app-id=${this.config.id}&` : '';
        const url = `${wp_api.rest_url}/${this.config.endpoint}?${appId}${query}`;
        return url;
    }

    loadmore(parameters = this.config) {
        const loadMoreButton = document.querySelector(parameters.selectors.loadmoreBtn);

        if ( null !== loadMoreButton ) {
            // const header = document.getElementById('header');
            // const paginationnArea = document.querySelector(parameters.selectors.pagination);

            loadMoreButton.addEventListener('click', (e) => {
                e.preventDefault();

                if ( parameters.nextPage && parameters.nextPage > 1  ) {
                    parameters.query.page = parameters.nextPage;
                    this.getDatas();

                    // if ( null !== paginationnArea && null !== header ) {
                    //     window.scroll(0, paginationnArea.offsetTop - (header.offsetHeight + 30));
                    // }
                }
            });
        }
    }
    filters(parameters = this.config) {
        const filtersCols = document.querySelectorAll(parameters.selectors.filter);

        if ( null !== filtersCols ) {
            const contentArea = document.querySelector(parameters.selectors.content);
            let filterTerms = (filters,termsType) => {
                return (termsType == 'array') ? Array.from(filters).filter(i => i.checked).map(i => i.value).filter(i => i) : filters.value;
            }
            let setQuery = (col,terms) => {
                let taxonomy = col.dataset.taxonomy;
                parameters.query[taxonomy] = terms.toString();
                parameters.query.page = 1;
                contentArea.innerHTML = '';
            }

            filtersCols.forEach(col => {
                const filtersCheckboxes = col.querySelectorAll('input[type="checkbox"]');
                const filtersRadios = col.querySelectorAll('input[type="radio"]');
                const filtersSelect = col.querySelectorAll('select');
                const checkboxAllContainer = col.querySelector('.form-check-all');
                const checkboxAll = col.querySelector('.form-check-input-all');

                if ( null !== contentArea && null !== filtersRadios ) {

                    filtersRadios.forEach(radio => {

                        radio.addEventListener('click', () => {
                            let terms = filterTerms(radio,'');
                            setQuery(col,terms);
                            this.getDatas();
                        });
                    });
                }
                if ( null !== contentArea && null !== filtersCheckboxes ) {

                    filtersCheckboxes.forEach(checkbox => {

                        checkbox.addEventListener('click', () => {
                            let terms = filterTerms(filtersCheckboxes,'array');
                            setQuery(col,terms);

                            if ( null !== checkboxAll && null !== checkboxAllContainer ) {

                                if ( terms && checkboxAll.checked == true ) {
                                    checkboxAll.checked = false;
                                    checkboxAllContainer.classList.remove('disabled');
                                }
                                if ( !terms.length && checkboxAll.checked == false ) {
                                    checkboxAll.checked = true;
                                    checkboxAllContainer.classList.add('disabled');
                                }
                                if ( checkbox.classList.contains('form-check-input-all') ) {

                                    filtersCheckboxes.forEach(checkbox => {

                                        if ( !checkbox.classList.contains('form-check-input-all') ) {
                                            checkbox.checked = false;
                                            checkboxAllContainer.classList.add('disabled');
                                        }
                                    });
                                    checkboxAll.checked = true;
                                    terms = [''];
                                    parameters.query[taxonomy] = terms.toString();
                                }
                            }

                            this.getDatas();
                        });
                    });
                }
                if ( null !== contentArea && null !== filtersSelect ) {

                    filtersSelect.forEach(select => {

                        select.addEventListener('change', () => {
                            let terms = filterTerms(select,'');
                            setQuery(col,terms);
                            this.getDatas();
                        });
                    });
                }
            });
        }
    }
    search(parameters = this.config) {
        const searchInput = document.querySelector(parameters.selectors.searchInput);
        const searchSubmit = document.querySelector(parameters.selectors.searchBtn);
        const contentArea = document.querySelector(parameters.selectors.content);

        if ( null !== searchInput && null !== searchSubmit && contentArea ) {

            searchSubmit.addEventListener('click', (e) => {
                e.preventDefault();

                let currentSearch = searchInput.value && (typeof searchInput.value === 'string') ? searchInput.value.toString() : '';
                parameters.query.page = 1;
                contentArea.innerHTML = '';
                parameters.query.search = currentSearch;
                this.getDatas();
            });
            searchInput.addEventListener('input', (e) => {

                if ( !searchInput.value ) {
                    parameters.query.page = 1;
                    parameters.query.search = '';
                    contentArea.innerHTML = '';
                    this.getDatas();
                }
            });
        }
    }
    pager(parameters = this.config) {
        const infosContainer = document.querySelector(parameters.selectors.informations);
        const hasPager = this.config.pager;
        const itemTitle = ` ${parameters.messages.item}${parameters.totalItems > 1 ? 's' : ''}`;
        let status = '';

        const pager = hasPager ? `, page ${parameters.currentPage}/${parameters.totalPages}` : '';

        if ( null !== infosContainer ) {

            if ( parameters.totalItems === 0 ) {
                status = parameters.messages.empty;
                infosContainer.dataset.status = 'ia-empty';
            }
            else if ( parameters.totalItems > 0 && ('search' in parameters.query && '' != parameters.query.search) ) {
                infosContainer.dataset.status = 'ia-search';
                const searchResultitemTitle = ` ${parameters.messages.results}${parameters.totalItems > 1 ? 's' : ''} pour "<b>${parameters.query.search}</b>"`;
                status = `${parameters.totalItems}${searchResultitemTitle}${pager}`;
            }
            else if ( parameters.totalItems > 0 ) {
                infosContainer.dataset.status = 'ia-total';
                status = hasPager ? `${parameters.totalItems}${itemTitle}${pager}` : '&nbsp;';
            }
            else {
                infosContainer.dataset.status = 'ia-error';
                status = parameters.messages.error;
            }

            infosContainer.innerHTML = `${status}`;
        }
    }
    pagination(parameters = this.config) {
        const currentpage = parseInt(parameters.query.page);
        const totalpages = parseInt(parameters.totalPages);
        const paginationArea = document.querySelector(parameters.selectors.pagination);

        if ( (currentpage && totalpages) && totalpages > 1 ) {
            const appId = parameters.id;
            let delta = '';
            let pagesHtml = '';
            const getRange = (start, end) => {
                return Array(end - start + 1)
                    .fill()
                    .map((v, i) => i + start);
            }
            if (totalpages <= 5) {
                delta = 5;
            } else {
                delta = currentpage > 4 && currentpage < totalpages - 3 ? 2 : 4;
            }
            const range = {
                start: Math.round(currentpage - delta / 2),
                end: Math.round(currentpage + delta / 2),
            }
            if (range.start - 1 === 1 || range.end + 1 === totalpages) {
                range.start += 1;
                range.end += 1;
            }
            let pages =
                currentpage > delta ?
                getRange(Math.min(range.start, totalpages - delta), Math.min(range.end, totalpages)) :
                getRange(1, Math.min(totalpages, delta + 1));
            const withDots = (value, pair) => (pages.length + 1 !== totalpages ? pair : [value]);
            if (pages[0] !== 1) {
                pages = withDots(1, [1, '...']).concat(pages);
            }
            if (pages[pages.length - 1] < totalpages) {
                pages = pages.concat(withDots(totalpages, ['...', totalpages]));
            }
            if ( pages ) {

                pages.forEach(page => {

                    let firstPage = page === 1 ? 'first ' : '';
                    let lastPage = page === totalpages ? 'last ' : '';
                    let activePage = page === currentpage ? ` class="page-numbers current" aria-current="page"` : '';

                    if ( page === '...' ) {
                        pagesHtml += `<span class="dots">${page}</span>`;
                    }
                    else {

                        if ( activePage ) {
                            pagesHtml += `<span${activePage}>${page}</span>`;
                        }
                        else {
                            pagesHtml += `<a class="${firstPage}${lastPage}page-numbers" href="${page}"><span>${page}</span></a>`;
                        }
                    }
                });
                let isFirstLink = currentpage && currentpage === 1;
                let isLastLink = currentpage && totalpages && (currentpage === totalpages);
                let prevLink = (parameters.paginate.type === 'pagination' && parameters.paginate.pagination.arrows) ? `<a class="nav-links-aside prev${ isFirstLink ? ' disabled' : ''}" href="${ isFirstLink ? currentpage : (currentpage - 1) }"><i class="fa-solid fa-arrow-left"></i><span>${parameters.paginate.pagination.prev}</span></a>` : '';
                let nextLink = (parameters.paginate.type === 'pagination' && parameters.paginate.pagination.arrows) ? `<a class="nav-links-aside next${ isLastLink ? ' disabled' : ''}" href="${ isLastLink ? totalpages : (currentpage + 1) }"><span>${parameters.paginate.pagination.next}</span><i class="fa-solid fa-arrow-right"></i></a>` : '';

                const paginationHtml = pagesHtml ? `<div class="pa-pagination pagination"><div class="nav-links-container">${prevLink}<div class="nav-links">${pagesHtml}</div>${nextLink}</div></div>` : '';

                if ( null !== paginationArea && paginationHtml ) {
                    paginationArea.innerHTML = paginationHtml;
                    const pagesLinks = document.querySelectorAll(`#${appId} .nav-links-container a`);

                    if ( null !== pagesLinks ) {

                        pagesLinks.forEach(link => {

                            link.addEventListener('click', (e) => {
                                e.preventDefault();

                                const current = document.querySelector(`#${appId} .page-numbers.current`);

                                if ( current ) {
                                    current.classList.remove('current');
                                    current.removeAttribute('aria-current');
                                }
                                if ( link.classList.contains('nav-links-aside') ) {
                                    let pageIndex = link.getAttribute('href').replace('#', '');
                                    let classicPages = pageIndex ? document.querySelector(`#${appId} .nav-links a[href="${pageIndex}"]`) : false;

                                    if ( classicPages ) {
                                        classicPages.classList.add('current');
                                    }
                                }
                                else {
                                    link.classList.add('current');
                                }

                                const pageNumber = link.getAttribute('href').replace('#', '');
                                parameters.query.page = pageNumber;
                                this.getDatas();
                            });
                        });
                    }
                }
            }
        }
        else {
            paginationArea.innerHTML = '';
        }
    }
    addLoader(parameters = this.config) {
        const appContainer = document.querySelector(parameters.selectors.container);
        const infosContainer = document.querySelector(parameters.selectors.informations);

        if ( null !== appContainer ) {
            const loadMoreButton = document.querySelector(parameters.selectors.loadmoreBtn);
            const filtersContainer = document.querySelector(parameters.selectors.filters);
            const contentArea = document.querySelector(parameters.selectors.content);

            if ( null !== infosContainer ) {
                infosContainer.dataset.status = 'ia-loading';
                infosContainer.innerText = parameters.messages.loading;
            }

            if ( null !== contentArea && parameters.paginate.type === 'pagination' ) {
                contentArea.innerHTML = '';
            }

            appContainer.classList.remove('loading-success');

            if ( null !== filtersContainer ) {
                filtersContainer.classList.add('is-filtering');
            }
            if ( null !== loadMoreButton ) {
                loadMoreButton.querySelector('span').innerHTML = `${parameters.paginate.loadmore.spinner} ${parameters.paginate.loadmore.loading}`;
            }
            if ( !parameters.skeleton.disable ) {
                const skeletonsList = document.querySelector(parameters.selectors.skeletonList);

                if ( null !== skeletonsList ) {
                    skeletonsList.classList.remove('d-none');
                }
            }
        }
    }
    removeLoader(parameters = this.config) {
        const appContainer = document.querySelector(parameters.selectors.container);

        if ( null !== appContainer ) {
            const loadMoreButton = document.querySelector(parameters.selectors.loadmoreBtn);
            const filtersContainer = document.querySelector(parameters.selectors.filters);

            if ( !parameters.skeleton.disable ) {
                const skeletonsList = document.querySelector(parameters.selectors.skeletonList);

                if ( null !== skeletonsList ) {
                    skeletonsList.classList.add('d-none');
                }
            }

            if ( null !== loadMoreButton ) {
                loadMoreButton.classList.add('d-none');
            }

            appContainer.classList.add('loading-success');

            if ( null !== filtersContainer ) {
                filtersContainer.classList.remove('is-filtering');
            }
            if ( null !== loadMoreButton && parseInt(parameters.nextPage) > 1 ) {
                loadMoreButton.querySelector('span').innerText = parameters.paginate.loadmore.more;
                loadMoreButton.classList.remove('d-none');
            }
        }
    }

    request = async ( url, _params = {} ) => {

        const args = {
            method: 'GET',
            headers: {
                'X-WP-Nonce': wp_api.nonce,
                'content-type': 'application/json',
            },
        };
        const response = await fetch(url, args);
        const searchUrl = new URL(url);
        const parameters = this.config;

        if (response.ok) {
            const contentType = response.headers.get('content-type');

            if (contentType && contentType.includes('application/json')) {
                const totalItems = parseInt(response.headers.get('X-WP-Total'));
                const totalPages = parseInt(response.headers.get('X-WP-TotalPages'));
                const searchCurrentPage = searchUrl && searchUrl.searchParams.get('page');
                const currentPage = searchCurrentPage && searchCurrentPage > 1 ? parseInt(searchCurrentPage) : parseInt(1);
                const nextPage = parseInt(totalPages) > 1 && parseInt(currentPage) < parseInt(totalPages) ? (currentPage + 1) : parseInt(0);

                parameters.totalItems = parseInt(totalItems);
                parameters.currentPage = parseInt(currentPage);
                parameters.totalPages = parseInt(totalPages);
                parameters.nextPage = parseInt(nextPage);

                return response.json();
            }
            else {
                return "This is not  JSON!";
            }
        }
        else {
            const contentArea = document.querySelector(parameters.selectors.content);

            if (contentArea) {
                contentArea.innerHTML = '';
            }
        }
    };

    async getDatas(url = this.url()) {

        this.addLoader();

        this.request(url)
        .then( datas => {
            if ( datas ) {
                const parameters = this.config;
                const contentArea = document.querySelector(parameters.selectors.content);
                const paginationArea = document.querySelector(parameters.selectors.pagination);

                if ( parameters && contentArea ) {
                    const paginateType = parameters.paginate.type;

                    if ( datas && datas.length ) {
                        let html = '';

                        datas.forEach(data => {
                            let item = this.template(data);
                            html += item;
                        });

                        if ( paginateType === 'pagination')  {
                            this.pagination();
                            contentArea.innerHTML = html;
                        }
                        else if ( paginateType === 'loadmore' ) {

                            if ( parameters.query.page && parameters.query.page <= 1 ) {
                                contentArea.innerHTML = html;                        ;
                            }
                            else {
                                contentArea.insertAdjacentHTML('beforeend',html);
                            }
                        }
                    }
                    else {
                        contentArea.innerHTML = '';

                        if ( parameters.paginate.type === 'pagination' ) {
                            paginationArea.innerHTML = '';
                        }
                    }
                }
            }
            this.removeLoader();
            this.pager();
        });
    }

    template(data) {
        return `<div class="col-sm-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title"><b>${data.title.rendered}</b></div>
                </div>
            </div>
        </div>`;
    }
}
