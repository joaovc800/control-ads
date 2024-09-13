import { loading } from "./utils.js"

const uploader = document.querySelector("#upload-file")

uploader.addEventListener("change", ({ target }) => {
    const [file] = target.files
    
    const reader = new FileReader()

    reader.onload = async function (event) {

        loading(true)

        const data = new Uint8Array(event.target.result);
        const workbook = XLSX.read(data, { type: 'array' })
        const [ sheetName ] = workbook.SheetNames
        const sheet = workbook.Sheets[sheetName]

        const headers = {};
        const rows = XLSX.utils.sheet_to_json(sheet, { header: 1 });
        rows.forEach(row => {
            row.forEach((cell, colIndex) => {
                const header = rows[0][colIndex];
                if (header && !headers[header]) {
                    headers[header] = true;
                }
            });
        });

        const json = XLSX.utils.sheet_to_json(sheet, { header: Object.keys(headers), defval: null });

        const request = await fetch('../controllers/uploadExcel.php', {
            method: 'POST',
            body: JSON.stringify({
                data: json.slice(1),
                file: file.name
            })
        })

        const response = await request.json()

        loading(false)

        // Create an instance of Notyf
        var notyf = new Notyf();

        // Display an error notification
        //notyf.error('You must fill out the form before moving forward');

        // Display a success notification
        notyf.success('Upload Realizado com sucesso!');
    };

    reader.readAsArrayBuffer(file);
})