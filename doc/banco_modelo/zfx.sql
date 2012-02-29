drop table if exists contato;

drop table if exists telefone;

drop table if exists usuario;

/*==============================================================*/
/* table: contato                                               */
/*==============================================================*/
create table contato
(
   co_contato           int not null auto_increment,
   co_usuario           int not null,
   no_contato           varchar(50) not null,
   no_apelido           varchar(40) default null,
   dt_cadastro          timestamp not null default current_timestamp,
   dt_alteracao         timestamp,
   primary key (co_contato)
);

/*==============================================================*/
/* table: telefone                                              */
/*==============================================================*/
create table telefone
(
   co_telefone          int not null auto_increment,
   co_contato           int not null,
   st_tipo              char(1) not null default 'C',
   nu_ddd               char(2) not null,
   nu_telefone          char(8) not null,
   dt_cadastro          timestamp default current_timestamp,
   primary key (co_telefone)
);

/*==============================================================*/
/* table: usuario                                               */
/*==============================================================*/
create table usuario
(
   co_usuario           int not null auto_increment,
   no_usuario           varchar(30) not null,
   ds_email             varchar(50) not null,
   ds_senha             varchar(50) not null,
   dt_cadastro          timestamp not null default current_timestamp,
   dt_alteracao         timestamp,
   primary key (co_usuario)
);

alter table contato add constraint fk_usuario_on_contato foreign key (co_usuario)
      references usuario (co_usuario) on delete restrict;

alter table telefone add constraint fk_contato_on_telefone foreign key (co_contato)
      references contato (co_contato) on delete restrict;
