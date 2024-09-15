import { loading } from "./utils.js"

const tableContainerUploads = document.querySelector('.table-container-uploads')

loading(true)

const request = await fetch('../controllers/getAllUploads.php');

const { success, data, message } = await request.json()

loading(false)

const notify = new Notyf()

if (success) {

    tableContainerUploads.classList.remove('is-hidden')

    function inicializeTooltips() {

        /* tippy('.btn-copy', {
            content: 'Copiar CSV',
            placement: 'top',
            arrow: true
        }) */

        tippy('.btn-delete', {
            content: 'Deletar campanha',
            placement: 'top',
            arrow: true
        })
    }

    const table = $('table').dataTable({
        columns: [
            { "data": 0, "title": "" },
            { "data": 1, "title": "ID" },
            { "data": 2, "title": "Data de upload" },
            { "data": 3, "title": "Campanha" },
            { "data": 4, "title": "Ações" },
        ],
        language: {
            lengthMenu: "Exibir registros _MENU_ por página",
            zeroRecords: "Registros não encontrados",
            info: "Mostrando a página _PAGE_ de _PAGES_",
            infoEmpty: "Não há registros disponíveis",
            emptyTable: "Não há registros disponíveis",
            infoFiltered: "filtrado do total de _MAX_ registros",
            search: "Pesquisar",
            paginate: {
                next: "Próximo",
                previous: "Anterior"
            }
        }
    })

    const api = table.api()

    data.forEach(({ id, campaign, date_upload, idcampaign }) => {
        const checkbox = `
            <input data-campaign-id="${idcampaign}" data-id="${id}" type="checkbox" class="is-clickable p-3 row-checkbox" />
        `

        const actions = `
            <div class="is-flex is-align-items-center is-gap-4">
                <i data-campaign-id="${idcampaign}" data-id="${id}" title="Copiar CSV" class="fas fa-copy is-clickable btn-copy"></i>
                <i data-campaign-id="${idcampaign}" data-id="${id}" title="Deletar campanha" class="fas fa-trash has-text-danger is-clickable btn-delete"></i>
            </div>
        `

        api.row.add([checkbox, id, date_upload, campaign, actions]).draw()
    });

    inicializeTooltips()

    api.on('draw', inicializeTooltips)

    $('.select-all-checkbox').on('change', function () {
        var isChecked = $(this).prop('checked')

        api.rows(function (idx, data, node) {
            $(node).find('.row-checkbox').prop('checked', isChecked)
            return $(node).find('.row-checkbox')
        })
    });

    $('#delete-button').on('click', async function () {

        const values = []

        var rows = api.rows(function (idx, data, node) {
            values.push({
                campaignId: $(node).find('.row-checkbox').attr('data-campaign-id'),
                campaignHeaderId: $(node).find('.row-checkbox').attr('data-id'),
            })
            return $(node).find('.row-checkbox').prop('checked')
        })

        loading(true)
        const request = await fetch('../controllers/deleteCampaign.php', {
            method: "POST",
            body: JSON.stringify(values)
        })

        const { success, data, message } = await request.json()

        loading(false)

        if (!success) {
            notify.error(message)
            return
        }

        rows.remove().draw()
        notify.success(message)

    });

    $('body').on('click', '.btn-delete', async function ({ target }) {
        const row = target.closest('tr')

        loading(true)

        const request = await fetch('../controllers/deleteCampaign.php', {
            method: "POST",
            body: JSON.stringify([{
                campaignId: $(target).attr('data-campaign-id'),
                campaignHeaderId: $(target).attr('data-id'),
            }])
        })

        const { success, data, message } = await request.json()

        loading(false)

        if (!success) {
            notify.error(message)
            return
        }

        api.row(row).remove().draw()

        notify.success(message)
    })

    $('body').on('click', '.btn-copy', async function ({ target }) {

        const instance = tippy(target, {
            content: "Copiar CSV",
            trigger: 'Click',
            onShow(i){
                i.setContent('CSV copiado')
            }
        })
        

        const campaignId = $(target).attr('data-campaign-id')

        const request = await fetch(`../controllers/getCsv.php?campaignId=${campaignId}`);

        const { success, data, message } = await request.json()

        if (success) {
            instance.show()
            navigator.clipboard.writeText(data.csv).then(() => {

                const checkbox = $(target).closest('tr').find('.row-checkbox')
                $(checkbox).prop('checked', true);
            }).catch(err => {
                instance.setContent('Falha ao copiar')
            })
        }
    })

} else {
    notify.error(message)
}
