<style>
    table{
        width:100%;
        border-collapse: collapse;
        /* border-color:black; */
    }
    table, th, td{
        border:1px solid #ddd;
    }
    tr th,td{
        text-align:center;
        width:50%;
    }
    tr th{
        background-color:black;
        color:white;
    }
    tr:nth-child(even) {background-color: #f2f2f2;}

    tfoot tr th,tfoot td{
        background-color:grey;
        color:white;
    }

</style>
<script>
    const selectElements = document.querySelectorAll(".display_currency");
    document.addEventListener("DOMContentLoaded", () => {
        for (const selectElement of selectElements) {
            const selectedValue = selectElement.options[selectElement.selectedIndex].value;
            const roundedValue = Math.round(selectedValue, 2);

            // Update the value of the selected option with the rounded value.
            selectElement.options[selectElement.selectedIndex].value = roundedValue;
        }
    });
</script>