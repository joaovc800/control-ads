import { generateTable } from "./utils.js"

const uploader = document.querySelector("#upload-file")
const tableContainer = document.querySelector(".table-container")

uploader.addEventListener("change", ({ target }) => {
    const [file] = target.files
    const reader = new FileReader()

    reader.onload = function (event) {
        const data = new Uint8Array(event.target.result);
        const workbook = XLSX.read(data, { type: 'array' })
        const [ sheetName ] = workbook.SheetNames
        const sheet = workbook.Sheets[sheetName]
        const json = XLSX.utils.sheet_to_json(sheet)

        console.log(json)

        generateTable({
            data: json,
            container: tableContainer,
            columnMapping: [
                { field: "CAMPAIGN", as: "Campanha" },
                { field: "GROUP", as: "Grupo" },
                { field: "BUDGET", as: "Orçamento" },
                { field: "TYPECAMPAIGN", as: "Tipo de Campanha" },
                { field: "INITIALCPC", as: "CPC Inicial" },
                { field: "CONVERSIONGOAL", as: "Meta de Conversão" },
                { field: "INITIALDATE", as: "Data Inicial" },
                { field: "URLNOTUTM", as: "URL sem UTM" },
                { field: "WORDSNOTUSED", as: "Palavras Não Utilizadas" },
                { field: "CTAHEADLINE1", as: "Título CTA" },
                { field: "UTMCAMPAGIN", as: "Campanha UTM" },
                { field: "UTMMEDIUM", as: "Meio UTM" },
                { field: "UTMSOURCE", as: "Fonte UTM" },
                { field: "LABEL", as: "Rótulo" },
                { field: "PREFIXSITELINK", as: "Prefixo do Link do Site" }
            ]
        })
    };

    reader.readAsArrayBuffer(file);
})