function printTable() {
    var table = document.getElementById('event-table');
    if (table) {
        var popup = window.open('', '_blank');
        popup.document.open();
        popup.document.write('<html><head><title>Print</title></head><body>');
        popup.document.write('<table>' + table.innerHTML + '</table>');
        popup.document.write('</body></html>');
        popup.document.close();
        popup.print();
    } else {
        alert('No table found!');
    }
}
function sortTable() {
    var table = document.getElementById('event-table');
    var rows = table.rows;
    var data = [];

    // Get the data from the table rows
    for (var i = 1; i < rows.length; i++) {
        var rowData = [];
        var cells = rows[i].cells;

        for (var j = 0; j < cells.length; j++) {
            rowData.push(cells[j].innerHTML);
        }

        data.push(rowData);
    }

    // Sort the data based on the preferred column (modify as per your preference)
    data.sort(function(a, b) {
        return a[0].localeCompare(b[0]); // Sort based on the first column (event name)
    });

    // Rebuild the table with the sorted data
    for (var i = 0; i < data.length; i++) {
        rows[i + 1].innerHTML = '<td>' + data[i].join('</td><td>') + '</td>';
    }
}