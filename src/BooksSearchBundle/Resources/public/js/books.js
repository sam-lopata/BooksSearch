$("#myModal").on("show.bs.modal", function(e) {
    var link = $(e.relatedTarget);
    $("#book-view-table").bootstrapTable("refresh", {
        url: link.attr("href")
    });
    $('.modal .modal-body').css('overflow-y', 'auto'); 
    $('.modal .modal-body').css('max-height', $(window).height() * 0.5);
});

$('#book-view-table').bootstrapTable({
    method: 'get',
    search: false,
    sort: false,
    showColumns: false,
    showRefresh: false,
    pagination: false,
    showHeader: true,
    cardView: true,
    columns: [
    {
        field: 'volumeInfo.title',
        title: 'Title:'
    }, {
        field: 'etag',
        title: 'ETAG:'
    },
    {
        field: 'volumeInfo.authors',
        title: 'Author:',
        formatter: 'authorsFormatter'
    },{
        field: 'volumeInfo.publishedDate',
        title: 'Published:'
    }, {
        field: 'volumeInfo.imageLinks.thumbnail',
        title: 'Cover:',
        formatter: 'imageFormatter'
    }, {
        field: 'volumeInfo.description',
        title: 'Description:'
    }]   
});

function imageFormatter(value) {
    return '<img src="' + value + '" />';
}

function authorsFormatter(value) {
    var authors = '';

    // Loop through the authors object
    for (var index = 0; index < value.length; index++) {
        authors += value[index].name;

        // Only show a comma if it's not the last one in the loop
        if (index < (value.length - 1)) {
            authors += ', ';
        }
    }
    return authors;
}