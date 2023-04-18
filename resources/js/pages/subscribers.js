import DataTable from 'datatables.net-dt';

export class SubscribersManager {

    nextCursor = null
    prevCursor = null
    isNext = true
    perPage = 10

    constructor() {
        this.table = new DataTable('#subscribers', {
            serverSide: true,
            dom: 'lfrti',
            processing: true,
            select: true,
            ordering: false,
            language: { "processing": '<div class="d-flex justify-content-center"></div>' },
            lengthMenu: [
                [10, 25, 50],
                [10, 25, 50],
            ],
            ajax: {
                url: '/subscribers/all',
                type: 'POST',
                order: [[0, 'desc']],
                data: d => {
                    d.cursor = this.getCurrentCursor();
                },
                beforeSend: xhr => {
                    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                }
            },
            columnDefs: [
                {
                    targets: -1,
                    data: null,
                    render: function ( data, type, row, meta ) {
                        const id = data[5];
                        return `<a class="delete-btn btn btn-sm btn-outline-danger" data-href="/subscribers/delete/${id}">×</a>`;
                    }
                },
                {
                    targets: 0,
                    data: null,
                    render: function ( data, type, row, meta ) {
                        const id = data[5];
                        const email = data[0];
                        return `<a class="" href="/subscribers/update/${id}">${email}</a>`;
                    }
                },
            ],
        })
    }

    events() {
        document.getElementById('prev').addEventListener('click', e => {
            this.isNext = false
            this.table.ajax.reload();
        })

        document.getElementById('next').addEventListener('click', e => {
            this.isNext = true
            this.table.ajax.reload();
        })

        this.table.on( 'xhr', () => {
            const json = this.table.ajax.json();
            this.nextCursor = json.next_cursor || null
            this.prevCursor = json.prev_cursor || null
            this.perPage = json.per_page || null
            this.disablePaginationBtns()
        })

        document.getElementById('subscribers').addEventListener('click', e => {
            const el = e.target
            if (el.classList.contains('delete-btn') && !el.hasAttribute('disabled')) {
                el.setAttribute('disabled', 'disabled')
                el.classList.add('disabled')
                const url = el.dataset.href
                if (url) {
                    this.deleteSubscriber(url, el)
                }
            }
        })
    }

    getCurrentCursor() {
        const perPage = parseInt(document.querySelector('[name="subscribers_length"]').value)
        if (this.perPage !== perPage) {
            return null;
        }
        return this.isNext ? this.nextCursor : this.prevCursor
    }

    disablePaginationBtns() {
        const paginationWrapEl = document.querySelector('.table-pagination.hide')
        paginationWrapEl ? paginationWrapEl.classList.remove('hide') : true
        document.getElementById('prev').disabled = !this.prevCursor
        document.getElementById('next').disabled = !this.nextCursor
    }

    async deleteSubscriber(url, el) {
        const {data} = await axios.delete(url)

        if (data.success) {
            this.isNext = true
            this.nextCursor = false
            this.prevCursor = false
            this.table.ajax.reload();
        } else {
            el.removeAttribute('disabled')
            el.classList.remove('disabled')
        }
    }
}
