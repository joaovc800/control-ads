export function generateTable({ data, container, columnMapping = [] }) {
    const tableContainer = container

    if (!data || data.length === 0) {
        tableContainer.innerHTML = '<p>Sem dados para exibir.</p>'
        return
    }

    const table = document.createElement('table')
    const thead = document.createElement('thead')
    const tbody = document.createElement('tbody')

    table.classList.add("table", "is-fullwidth")

    // Verificar se columnMapping foi fornecido
    if (columnMapping.length > 0) {
        // Criação do cabeçalho com mapeamento de colunas
        const headerRow = document.createElement('tr')
        columnMapping.forEach(({ field, as }) => {
            const th = document.createElement('th')
            th.textContent = as || field
            headerRow.appendChild(th)
        })
        thead.appendChild(headerRow)

        // Criação do corpo da tabela
        data.forEach(item => {
            const row = document.createElement('tr')
            columnMapping.forEach(({ field }) => {
                const td = document.createElement('td')
                td.textContent = item[field] || ''
                row.appendChild(td)
            })
            tbody.appendChild(row)
        })
    } else {
        // Se columnMapping não for fornecido, deduzir as colunas das chaves do primeiro objeto
        const fields = Object.keys(data[0])

        // Criação do cabeçalho com base nas chaves do primeiro objeto
        const headerRow = document.createElement('tr')
        fields.forEach(field => {
            const th = document.createElement('th')
            th.textContent = field
            headerRow.appendChild(th)
        })
        thead.appendChild(headerRow)

        // Criação do corpo da tabela
        data.forEach(item => {
            const row = document.createElement('tr')
            fields.forEach(field => {
                const td = document.createElement('td')
                td.textContent = item[field] || ''
                row.appendChild(td)
            })
            tbody.appendChild(row)
        })
    }

    table.appendChild(thead)
    table.appendChild(tbody)
    tableContainer.innerHTML = ''
    tableContainer.appendChild(table)
}

export function loading(status){
    if(status){
        const parser = new DOMParser()
        const string = `
            <div class="loader-container">
                <div class="loader"></div>
            </div>
        `
        const html = parser.parseFromString(string, 'text/html').body.firstChild
        document.body.appendChild(html)
        return
    }

    const loader = document.querySelector(".loader-container")
    if(loader) loader.remove()
}