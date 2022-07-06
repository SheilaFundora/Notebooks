create table ropa
(
    id int auto_increment,
    sku varchar(50) not null,
    image varchar(255) not null,
    nombre varchar(150) not null,
    description varchar(500) null,
    color varchar(255) not null,
    talla varchar(10) not null,
    precio_por_dia decimal(10,2) not null,
    created_at datetime default NOW() not null,
    updated_at datetime default NOW() not null,
    deleted_at datetime default NULL null,
    constraint ropa_pk
        primary key (id)
);

create unique index ropa_sku_uindex
    on ropa (sku);

