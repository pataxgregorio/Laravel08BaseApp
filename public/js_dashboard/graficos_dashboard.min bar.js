jQuery.ajax({
    url: "/users/usuarioRol",
    type: "GET",
    error: function () {},
    dataType: "json",
    success: function (r) {
        var a = [],
            b = [];
        jQuery.each(r, function (r, e) {
            a.push(e.NAME_ROLS), b.push(e.TOTAL_USERS);
        });
        var e = document.getElementById("countUserRol").getContext("2d");
        new Chart(e, {
            type: "bar",
            data: {
                labels: a,
                datasets: [
                    {
                        label: "TOP 10 Usuarios por ROL",
                        data: b,
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.2)",
                            "rgba(54, 162, 235, 0.2)",
                            "rgba(255, 206, 86, 0.2)",
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(153, 102, 255, 0.2)",
                            "rgba(255, 159, 64, 0.2)",
                            "rgba(180, 60, 132, 0.2)",
                            "rgba(103, 162, 46, 0.2)",
                            "rgba(175, 206, 86, 0.2)",
                            "rgba(22, 40, 60, 0.2)",
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)",
                            "rgba(180, 60, 132, 1)",
                            "rgba(103, 162, 46, 1)",
                            "rgba(175, 206, 86, 1)",
                            "rgba(22, 40, 60, 1)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: { scales: { yAxes: [{ ticks: { beginAtZero: !0 } }] } },
        });
    },
}),
    jQuery.ajax({
        url: "/users/notificationsUser",
        type: "GET",
        error: function () {},
        dataType: "json",
        success: function (r) {
            var a = [],
                b = [];
            jQuery.each(r, function (r, e) {
                a.push(e.USER_NAME), b.push(e.TOTAL_NOTIFICATIONS);
            });
            var e = document
                .getElementById("notificationsUser")
                .getContext("2d");
            new Chart(e, {
                type: "bar",
                data: {
                    labels: a,
                    datasets: [
                        {
                            label: "TOP 10 Notificaciones por Usuarios",
                            data: b,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                                "rgba(180, 60, 132, 0.2)",
                                "rgba(103, 162, 46, 0.2)",
                                "rgba(175, 206, 86, 0.2)",
                                "rgba(22, 40, 60, 0.2)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                                "rgba(180, 60, 132, 1)",
                                "rgba(103, 162, 46, 1)",
                                "rgba(175, 206, 86, 1)",
                                "rgba(22, 40, 60, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: { yAxes: [{ ticks: { beginAtZero: !0 } }] },
                },
            });
        },
    }),
    jQuery.ajax({
        url: "/users/notificationsUser",
        type: "GET",
        error: function () {},
        dataType: "json",
        success: function (data) {
            var array_NAME_USER = [];
            var array_TOTAL_NOTIFICATIONS = [];
            jQuery.each(data, function (index, value) {
                array_NAME_USER.push(value.USER_NAME);
                array_TOTAL_NOTIFICATIONS.push(value.TOTAL_NOTIFICATIONS);
            });
            var ctx = document
                .getElementById("notificationsUser")
                .getContext("2d");
            var notificationsUser = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: array_NAME_USER,
                    datasets: [
                        {
                            label: "Tipo de Solicitudes",
                            data: array_TOTAL_NOTIFICATIONS,
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)",
                                "rgba(180, 60, 132, 0.2)",
                                "rgba(103, 162, 46, 0.2)",
                                "rgba(175, 206, 86, 0.2)",
                                "rgba(22, 40, 60, 0.2)",
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)",
                                "rgba(180, 60, 132, 1)",
                                "rgba(103, 162, 46, 1)",
                                "rgba(175, 206, 86, 1)",
                                "rgba(22, 40, 60, 1)",
                            ],
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                },
                            },
                        ],
                    },
                },
            });
        },
    });
jQuery.ajax({
    url: "/solicitud/solicitudTipo",
    type: "GET",
    error: function () {},
    dataType: "json",
    success: function (data) {
        var array_NAME_USER = [];
        var array_TOTAL_NOTIFICATIONS = [];
        jQuery.each(data, function (index, value) {
            array_NAME_USER.push(value.SOLICITUD_NOMBRE);
            array_TOTAL_NOTIFICATIONS.push(value.TOTAL_SOLICITUD);
        });
        var ctx = document.getElementById("solicitudTipo").getContext("2d");
        var solicitudTipo = new Chart(ctx, {
            type: "bar",
            data: {
                labels: array_NAME_USER,
                datasets: [
                    {
                        label: "Total de Solicitudes por tipo",
                        data: array_TOTAL_NOTIFICATIONS,
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.2)",
                            "rgba(54, 162, 235, 0.2)",
                            "rgba(255, 206, 86, 0.2)",
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(153, 102, 255, 0.2)",
                            "rgba(255, 159, 64, 0.2)",
                            "rgba(180, 60, 132, 0.2)",
                            "rgba(103, 162, 46, 0.2)",
                            "rgba(175, 206, 86, 0.2)",
                            "rgba(22, 40, 60, 0.2)",
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)",
                            "rgba(180, 60, 132, 1)",
                            "rgba(103, 162, 46, 1)",
                            "rgba(175, 206, 86, 1)",
                            "rgba(22, 40, 60, 1)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                            },
                        },
                    ],
                },
            },
        });
    },
});
jQuery.ajax({
    url: "/solicitud/solicitudTotalTipo",
    type: "GET",
    error: function () {},
    dataType: "json",
    success: function (data) {
        var array_NAME_USER = [];
        var array_TOTAL_NOTIFICATIONS = [];
        jQuery.each(data, function (index, value) {
            array_NAME_USER.push("TOTAL SOLICITUDES");
            array_TOTAL_NOTIFICATIONS.push(value.TOTAL_SOLICITUD);
        });
        var ctx = document
            .getElementById("solicitudTotalTipo")
            .getContext("2d");
        var solicitudTipo = new Chart(ctx, {
            type: "bar",
            data: {
                labels: array_NAME_USER,
                datasets: [
                    {
                        label: "Total de Solicitudes",
                        data: array_TOTAL_NOTIFICATIONS,
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.2)",
                            "rgba(54, 162, 235, 0.2)",
                            "rgba(255, 206, 86, 0.2)",
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(153, 102, 255, 0.2)",
                            "rgba(255, 159, 64, 0.2)",
                            "rgba(180, 60, 132, 0.2)",
                            "rgba(103, 162, 46, 0.2)",
                            "rgba(175, 206, 86, 0.2)",
                            "rgba(22, 40, 60, 0.2)",
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)",
                            "rgba(180, 60, 132, 1)",
                            "rgba(103, 162, 46, 1)",
                            "rgba(175, 206, 86, 1)",
                            "rgba(22, 40, 60, 1)",
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    yAxes: [
                        {
                            ticks: {
                                beginAtZero: true,
                            },
                        },
                    ],
                },
            },
        });
    },
});
