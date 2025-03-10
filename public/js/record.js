$(document).ready(function () {
    $(document).on("click", "#submitEditBtn", function (event) {
        event.preventDefault();

        let recordID = $("#editRecordModal").attr("data-record-id");

        let updatedData = {
            id: recordID,
            title: $("#editTitle").val().trim(),
            documents: $("#editDocuments").val().trim(),
            start_date: $("#editStartDate").val().trim(),
            end_date: $("#editEndDate").val().trim(),
            volume: $("#editVolume").val().trim(),
            medium: $("#editmedium").val().trim(),
            location: $("#editLocation").val().trim(),
            time_value: $("#editTimeValue").val().trim(),
            utility_value: $("#editUtilityValue").val().trim(),
            disposition: $("#editDisposition").val().trim(),
            grds_item: $("#editGrdsItem").val().trim(),
            duplication: $("#editDuplication").val().trim(),
        };

        $.ajax({
            url: "/update-record",
            type: "POST",
            data: updatedData,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (response) {
                console.log(response);

                if (response.status === "success") {
                    alert("Record updated successfully!");
                    
                    // Update row in table
                    let editingRow = $("tr[data-id='" + recordID + "']");
                    editingRow.find("td").eq(0).text(updatedData.title);
                    editingRow.find("td").eq(1).text(updatedData.documents);
                    editingRow.find("td").eq(2).text(updatedData.start_date + " to " + updatedData.end_date);
                    editingRow.find("td").eq(3).text(updatedData.volume);
                    editingRow.find("td").eq(4).text(updatedData.medium);
                    editingRow.find("td").eq(5).text(updatedData.location);
                    editingRow.find("td").eq(6).text(updatedData.time_value);
                    editingRow.find("td").eq(7).text(updatedData.utility_value);
                    editingRow.find("td").eq(8).text(updatedData.disposition);
                    editingRow.find("td").eq(9).text(updatedData.grds_item);
                    editingRow.find("td").eq(10).text(updatedData.duplication);

                    $("#editRecordModal").fadeOut();
                } else {
                    alert("Error updating record.");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + error);
                alert("Error updating record!");
            }
        });
    });
});