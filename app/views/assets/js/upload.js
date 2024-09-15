import { loading } from "./utils.js"

const uploader = document.querySelector("#upload-file")
const errors = document.querySelector("#errors")

uploader.addEventListener("change", ({ target }) => {
    const [file] = target.files
    
    const reader = new FileReader()

    reader.onload = async function (event) {

        loading(true)

        const data = new Uint8Array(event.target.result)
        const workbook = XLSX.read(data, { type: 'array' })
        const [ sheetName ] = workbook.SheetNames
        const sheet = workbook.Sheets[sheetName]

        const headers = {}
        const rows = XLSX.utils.sheet_to_json(sheet, { header: 1 })
        rows.forEach(row => {
            row.forEach((cell, colIndex) => {
                const header = rows[0][colIndex]
                if (header && !headers[header]) {
                    headers[header] = true
                }
            })
        })

        const json = XLSX.utils.sheet_to_json(sheet, { header: Object.keys(headers), defval: null })

        const notyf = new Notyf()

        for (const excelData of json.slice(1)) {
            
            const request = await fetch('../controllers/uploadExcel.php', {
                method: 'POST',
                body: JSON.stringify({
                    data: [excelData],
                    file: file.name
                })
            })

            const { data, message, success} = await request.json()

            if(success){
                notyf.success(`#${data.name} - ${message}`)
            }else{
                notyf.error(`${message}`)

                errors.innerHTML += `
                    <article class="message is-danger py-1">
                        <div class="message-body">
                            ${message}
                        </div>
                    </article>
                `
            }
        }

        loading(false)
        
    }

    reader.readAsArrayBuffer(file)
})