new gridjs.Grid({
    columns: [{
        id: 'name',
        name: 'Timestamp'
    },{
        id: 'code',
        name: 'Host'
    },{
        id: 'icon',
        name: 'IPv4'
    }],
    pagination: {
    enabled: true,
    limit: 5,
        server: {
            url: (prev, page, limit) => `${prev}?limit=${limit}&offset=${page * limit}`
        }
    },
    sort: !0,
    search: {
        server: {
          url: (prev, keyword) => `${prev}?search=${keyword}`
        }
      },
    server: {
        url: "http://localhost/bengkel/menu",
        then: data => data.map(movie => [movie.name, movie.code, movie.icon]),
        total: data => data.count
    } 
}).render(document.getElementById("table-gridjs"));
