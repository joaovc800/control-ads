import { loading  } from "./utils.js"

loading(true)

const request = await fetch('../controllers/getAllUploads.php');

const { success, data, message } = await request.json()

loading(false)

const notify = new Notyf()

if(success){

    const table = $('table').dataTable({
        columns: [
            { "data": 0, "title": "ID" },
            { "data": 1, "title": "Data de upload" },
            { "data": 2, "title": "Campanha" },
            { "data": 3, "title": "Ações" },
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

    data.forEach(({ id, campaign, date_upload, idcampaign}) => {
        const actions = `
            <div class="is-flex is-align-items-center is-gap-4">
                <i data-campaign-id="${idcampaign}" data-id="${id}" title="Copiar CSV" class="fas fa-copy is-clickable btn-copy"></i>
            </div>
        `

        api.row.add([id, date_upload, campaign, actions]).draw()
    });

    tippy('.btn-copy', { 
        content: 'Copiar CSV',
        trigger: 'click',
        async onShow(instance){

            const campaignId = $(instance.reference).attr('data-campaign-id')

            const request = await fetch(`../controllers/getCsv.php?campaignId=${campaignId}`);

            const { success, data, message } = await request.json()

            if(success){

                navigator.clipboard.writeText(data.csv).then(() => {
                    instance.setContent(message)
                }).catch(err => {
                    instance.setContent('Falha ao copiar')
                });

                return
            }
        }

    })

}else{
    notify.error(message)
}
