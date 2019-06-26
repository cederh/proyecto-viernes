-- Creacion de la base de datos
-- --------------------------------------------------
-- Aumentamos el numero de divice permitidos a 20
sp_configure "number of devices", 20
go
use master
go
-- Creamos los divice (tablespace) para datos y para log
disk init name='friday_dat', physname='/opt/sap/data/friday_dat.dat', size='50m'
go
disk init name='friday_log', physname='/opt/sap/data/friday_log.dat', size='50m'
go
-- Creamos la base de datos utilizando los divice creados previamente
create database dbfriday
on friday_dat = 50
log on friday_log = 50
go

-- Creacion de tablas
-- -------------------------------------------------------
-- Tabla usuarios
CREATE TABLE dbfriday.dbo.tbl_users (
	id_user int,
	name varchar(50) NOT NULL,
	last_name varchar(50) NOT NULL,
	birthdate date NOT NULL,
	gender int NOT NULL,
	email varchar(20) NOT NULL,
	password varchar(128) NOT NULL,
	user_type int NOT NULL,
	status int NOT NULL,
	CONSTRAINT tbl_users_PK PRIMARY KEY (id_user)
) go

-- Tabla respuestas
CREATE TABLE dbfriday.dbo.tbl_answers (
	id_answer int NOT NULL,
	id_user int NOT NULL,
	answer varchar(500) NOT NULL,
	n_keywords int NOT NULL,
	insert_date datetime NOT NULL,
	id_user_update int,
	update_date datetime,
	CONSTRAINT tbl_answers_PK PRIMARY KEY (id_answer),
	CONSTRAINT tbl_answers_FK FOREIGN KEY (id_user) REFERENCES dbfriday.dbo.tbl_users(id_user)
) go

-- Tabla palabras claves
CREATE TABLE dbfriday.dbo.tbl_keywords (
	id_keyword int,
	id_answer int NOT NULL,
	keyword varchar(25) NOT NULL,
	CONSTRAINT tbl_keywords_PK PRIMARY KEY (id_keyword),
	CONSTRAINT tbl_keywords_tbl_answers_FK FOREIGN KEY (id_answer) REFERENCES dbfriday.dbo.tbl_answers(id_answer)
) go
-- Tabla pacientes
CREATE TABLE dbfriday.dbo.tbl_patient (
	id_patient int NOT NULL,
	name varchar(50),
	last_name varchar(50),
	birthdate date,
	gender int,
	personality varchar(1),
	ci int,
	[character] varchar(1),
	email varchar(20),
	password varchar(128),
	id_user int,
	insert_date datetime,
	id_user_update int,
	update_date datetime,
	CONSTRAINT tbl_patient_PK PRIMARY KEY (id_patient),
	CONSTRAINT tbl_patient_FK FOREIGN KEY (id_user) REFERENCES dbfriday.dbo.tbl_users(id_user)
) go

-- Tabla historial
CREATE TABLE dbfriday.dbo.tbl_chat_history (
	id_chat_history int,
	id_patient int NOT NULL,
	message varchar(500) NOT NULL,
	id_answer int NOT NULL,
	update_date datetime NOT NULL,
	CONSTRAINT tbl_chat_history_PK PRIMARY KEY (id_chat_history),
	CONSTRAINT tbl_chat_history_tbl_patient_FK FOREIGN KEY (id_patient) REFERENCES dbfriday.dbo.tbl_patient(id_patient),
	CONSTRAINT tbl_chat_history_tbl_answers_FK FOREIGN KEY (id_answer) REFERENCES dbfriday.dbo.tbl_answers(id_answer)
) go

-- Tabla para almacenar preguntas para los test
CREATE TABLE dbfriday.dbo.id_tests_questions (
	id_questions int NOT NULL,
	questions varchar(100) NOT NULL,
	answer varchar(100) NOT NULL,
	tests_type int NOT NULL,
	id_user int NOT NULL,
	insert_date datetime NOT NULL,
	id_user_update int,
	update_date datetime,
	CONSTRAINT id_tests_questions_PK PRIMARY KEY (id_questions),
	CONSTRAINT id_tests_questions_FK FOREIGN KEY (id_user) REFERENCES dbfriday.dbo.tbl_users(id_user)
) go


-- Tabla bitacora
CREATE TABLE dbfriday.dbo.tbl_binnacle (
	id_binnacle int NOT NULL,
	operation varchar(10) NOT NULL,
	table_name varchar(20) NOT NULL,
	new_data varchar(1000) NOT NULL,
	old_data varchar(1000) NOT NULL,
	dt datetime NOT NULL
) go

-- Creacion de procedimientos
-- -------------------------------------------------------------

-- Procedimiento para guardar un nuevo usuario
CREATE OR REPLACE proc add_user
	@name VARCHAR(45),
	@last_name VARCHAR(45),
	@birthdate DATE,
	@gender VARCHAR(1),
	@email VARCHAR(50),
	@password VARCHAR(400),
	@user_type VARCHAR(1)
AS
BEGIN
--	Declaramos variable para obtener el id anterior
	DECLARE @id int

--	Obtenemos el id anterior
	SELECT @id = MAX(id_user)
	FROM dbfriday.dbo.tbl_users

-- guardamos los datos del usuario
	INSERT INTO dbfriday.dbo.tbl_users
	(id_user, name, last_name, birthdate, gender, email, password, user_type, status)
	VALUES(@id + 1, @name, @last_name, @birthdate, CONVERT(int, @gender), @email, @password, CONVERT(int, @user_type), 1)
END


-- Procedimiento para modificar usuario
CREATE OR REPLACE proc update_user
	@name VARCHAR(45),
	@last_name VARCHAR(45),
	@birthdate DATE,
	@gender VARCHAR(1),
	@email VARCHAR(50),
	@user_type VARCHAR(1),
	@id VARCHAR(10)
AS
BEGIN
-- guardamos los datos del usuario
	UPDATE dbfriday.dbo.tbl_users
	SET name=@name, last_name=@last_name, birthdate = @birthdate, gender=CONVERT(int, @gender), email=@email, user_type=CONVERT(int, @user_type)
	WHERE id_user=CONVERT(int, @id)
END


-- Procedimiento para desactivar usuario
CREATE OR REPLACE proc disable_user
	@id VARCHAR(10)
AS
BEGIN
-- cambiamos el estado del usuario
	UPDATE dbfriday.dbo.tbl_users
	SET status = 0
	WHERE id_user=CONVERT(int, @id)
END


-- Procedimiento para activar usuarios
CREATE OR REPLACE proc enable_user
	@id VARCHAR(10)
AS
BEGIN
-- cambiamos el estado del usuario
	UPDATE dbfriday.dbo.tbl_users
	SET status = 1
	WHERE id_user=CONVERT(int, @id)
END

-- Procedimiento para Actualizar contraseña
CREATE OR REPLACE proc update_password
	@password VARCHAR(400),
	@id VARCHAR(10)
AS
BEGIN
-- guardamos la contraseña del usuario
	UPDATE dbfriday.dbo.tbl_users
	SET password=@password
	WHERE id_user=CONVERT(int, @id)
END


-- Procedimiento para guardar una nueva respuesta
CREATE OR REPLACE proc add_answer
	@id_user VARCHAR(11),
	@answer VARCHAR(500),
	@id_user_update VARCHAR(11)

AS
BEGIN
--	Declaramos variable para obtener el id anterior
	DECLARE @id int

--	Obtenemos el id anterior
	SELECT @id = isNull(MAX(id_user), 0) + 1
	FROM dbfriday.dbo.tbl_answers

-- guardamos los datos del usuario
	INSERT INTO dbfriday.dbo.tbl_answers
	(id_answer, id_user, answer, insert_date, id_user_update, update_date)
	VALUES(@id, CONVERT(INT, @id_user), @answer, getdate(), CONVERT(INT, @id_user), getdate())
END

-- Procedimiento para guardar una palabra clave
CREATE OR REPLACE proc add_keyword
	@id_answer INT,
	@keyword VARCHAR(25)
AS
BEGIN
--	Declaramos variable para obtener el id anterior
	DECLARE @id int

--	Obtenemos el id anterior
	SELECT @id = isNull(MAX(id_keyword), 0) + 1
	FROM dbfriday.dbo.tbl_keywords

-- guardamos los datos del usuario
	INSERT INTO dbfriday.dbo.tbl_keywords
	(id_keyword, id_answer, keyword)
	VALUES(@id, @id_answer, @keyword)
END

-- Procedimiento para guardar un nuevo paciente
CREATE OR REPLACE proc add_patient
	@name VARCHAR(45),
	@last_name VARCHAR(45),
	@birthdate DATE,
	@gender VARCHAR(1),
	@email VARCHAR(50),
	@password VARCHAR(400),
	@id_user INT
AS
BEGIN
--	Declaramos variable para obtener el id anterior
	DECLARE @id int

--	Obtenemos el id anterior
	SELECT @id = isNull(MAX(id_patient), 0) + 1
	FROM dbfriday.dbo.tbl_patient

-- guardamos los datos del paciente
	INSERT INTO dbfriday.dbo.tbl_patient
	(id_patient, name, last_name, birthdate, gender, personality, ci, [character], email, password, id_user, insert_date, id_user_update, update_date)
	VALUES(@id, @name, @last_name, @birthdate, CONVERT(INT, @gender), '', '', '', @email, @password, CONVERT(INT, @id_user), getdate(), CONVERT(INT, @id_user), getdate())

END

-- Procedimiento para Actualizar Pacientes
CREATE OR REPLACE proc update_patient
@name VARCHAR(45),
@last_name VARCHAR(45),
@birthdate DATE,
@gender VARCHAR(1),
@email VARCHAR(50),
@id_user INT,
@id VARCHAR(10)
AS
BEGIN
-- guardamos los datos del Paciente
UPDATE dbfriday.dbo.tbl_patient
SET name=@name, last_name=@last_name, birthdate = @birthdate, gender=CONVERT(int, @gender), email=@email, id_user_update=@id_user, update_date=getdate()
WHERE id_patient=CONVERT(int, @id)
END

-- Procedimiento para Actualizar contraseña de los Pacientes
CREATE OR REPLACE proc update_passwordPatient
	@password VARCHAR(400),
	@id_user INT,
	@id VARCHAR(10)
AS
BEGIN
-- guardamos la contraseña del Paciente
	UPDATE dbfriday.dbo.tbl_patient
	SET password=@password, id_user_update=@id_user, update_date=getdate()
	WHERE id_patient=CONVERT(int, @id)
END

-- Procedimiento para guardar un nuevo paciente
CREATE OR REPLACE proc add_acount
	@name VARCHAR(45),
	@last_name VARCHAR(45),
	@birthdate DATE,
	@gender VARCHAR(1),
	@email VARCHAR(50),
	@password VARCHAR(400)
AS
BEGIN
--	Declaramos variable para obtener el id anterior
	DECLARE @id int

--	Obtenemos el id anterior
	SELECT @id = isNull(MAX(id_patient), 0) + 1
	FROM dbfriday.dbo.tbl_patient

-- guardamos los datos del paciente
	INSERT INTO dbfriday.dbo.tbl_patient
	(id_patient, name, last_name, birthdate, gender, personality, ci, [character], email, password, id_user, insert_date, id_user_update, update_date)
	VALUES(@id, @name, @last_name, @birthdate, CONVERT(INT, @gender), '', '', '', @email, @password, 1, getdate(), 1, getdate())

END

-- Procedimiento para que el paciente actualice sus datos.
CREATE OR REPLACE proc update_acount
@name VARCHAR(45),
@last_name VARCHAR(45),
@birthdate DATE,
@gender VARCHAR(1),
@email VARCHAR(50),
@id VARCHAR(10)
AS
BEGIN
-- guardamos los datos del Paciente
UPDATE dbfriday.dbo.tbl_patient
SET name=@name, last_name=@last_name, birthdate = @birthdate, gender=CONVERT(int, @gender), email=@email, id_user_update=1, update_date=getdate()
WHERE id_patient=CONVERT(int, @id)
END

-- Procedimiento para que el paciente actualice su contraseña
CREATE OR REPLACE proc update_passwordAcount
	@password VARCHAR(400),
	@id VARCHAR(10)
AS
BEGIN
-- guardamos la contraseña del Paciente
	UPDATE dbfriday.dbo.tbl_patient
	SET password=@password, id_user_update=1, update_date=getdate()
	WHERE id_patient=CONVERT(int, @id)
END

-- Procedimiento para almacenar historial
CREATE OR REPLACE proc add_history
	@id_patient INT,
	@message VARCHAR(500),
	@id_answer INT
AS
BEGIN
--	Declaramos variable para obtener el id anterior
	DECLARE @id int

--	Obtenemos el id anterior
	SELECT @id = isNull(MAX(id_chat_history), 0) + 1
	FROM dbfriday.dbo.tbl_chat_history

-- guardamos los datos del historial
	INSERT INTO dbfriday.dbo.tbl_chat_history
	(id_chat_history, id_patient, message, id_answer, update_date)
	VALUES(@id, @id_patient, @message, @id_answer, getdate())

END

-- TRIGGERS
-- -----------------------------------------------------------

-- Triger para la tabla tbl_users INSERT
CREATE OR REPLACE TRIGGER dbo.tg_insert_users
ON dbo.tbl_users
FOR INSERT
AS
-- Declaramos variables
	DECLARE @new_id INT, @new_name VARCHAR(45), @new_last_name VARCHAR(45), @new_birthdate DATE,
	@new_gender INT, @new_email VARCHAR(50), @new_user_type INT, @new_status INT, @id INT,
	@new_data VARCHAR(300)

--	Obtenemos los datos nuevos
	SELECT @new_id = id_user, @new_name = name, @new_last_name = last_name, @new_birthdate = birthdate,
	@new_gender = gender, @new_email = email, @new_user_type = user_type, @new_status = status
	FROM inserted

-- creamos la cadena de los datos nuevos
	SET @new_data = 'id_user = ' + convert(varchar, @new_id) + '| name = ' + @new_name +
	'| last_name = ' + @new_last_name + '| birthdate = ' + CONVERT(VARCHAR, @new_birthdate) +
	'| gender = ' +	CONVERT(VARCHAR, @new_gender) + '| email = ' + @new_email + '| user_type = ' +
	CONVERT(VARCHAR, @new_user_type) + '| status = ' + CONVERT(VARCHAR, @new_status)

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'INSERT', 'TBL_USERS', @new_data , '', getdate())


-- Triger para la tabla tbl_users UPDATE
CREATE OR REPLACE TRIGGER dbo.tg_update_users
ON dbo.tbl_users
FOR UPDATE
AS
-- Declaramos variables
	DECLARE @old_id INT, @old_name VARCHAR(45), @old_last_name VARCHAR(45), @old_birthdate DATE,
	@old_gender INT, @old_email VARCHAR(50), @old_user_type INT, @old_status INT,
	@new_id INT, @new_name VARCHAR(45), @new_last_name VARCHAR(45), @new_birthdate DATE,
	@new_gender INT, @new_email VARCHAR(50), @new_user_type INT, @new_status INT, @id INT,
	@old_data VARCHAR(300), @new_data VARCHAR(300)

--	Obtenemos los datos viejos
	SELECT @old_id = id_user, @old_name = name, @old_last_name = last_name, @old_birthdate = birthdate,
	@old_gender = gender, @old_email = email, @old_user_type = user_type, @old_status = status
	FROM deleted

-- creamos la cadena de los datos viejos
	SET @old_data = 'id_user = ' + convert(varchar, @old_id) + '| name = ' + @old_name +
	'| last_name = ' + @old_last_name + '| birthdate = ' + CONVERT(VARCHAR, @old_birthdate) +
	'| gender = ' +	CONVERT(VARCHAR, @old_gender) + '| email = ' + @old_email + '| user_type = ' +
	CONVERT(VARCHAR, @old_user_type) + '| status = ' + CONVERT(VARCHAR, @old_status)

--	Obtenemos los datos nuevos
	SELECT @new_id = id_user, @new_name = name, @new_last_name = last_name, @new_birthdate = birthdate,
	@new_gender = gender, @new_email = email, @new_user_type = user_type, @new_status = status
	FROM inserted

-- creamos la cadena de los datos nuevos
	SET @new_data = 'id_user = ' + convert(varchar, @new_id) + '| name = ' + @new_name +
	'| last_name = ' + @new_last_name + '| birthdate = ' + CONVERT(VARCHAR, @new_birthdate) +
	'| gender = ' +	CONVERT(VARCHAR, @new_gender) + '| email = ' + @new_email + '| user_type = ' +
	CONVERT(VARCHAR, @new_user_type) + '| status = ' + CONVERT(VARCHAR, @new_status)

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'UPDATE', 'TBL_USERS', @new_data , @old_data, getdate())

-- Triger para la tabla TBL_ANSWER INSERT
CREATE OR REPLACE TRIGGER dbo.tg_insert_answer
ON dbo.tbl_answers
FOR INSERT
AS
-- Declaramos variables
	DECLARE @new_id INT, @new_id_user INT, @new_answer VARCHAR(500), @new_insert_date DATETIME,
	@new_id_user_update INT, @new_update_date DATETIME, @new_data VARCHAR(400), @id INT

--	Obtenemos los datos nuevos
	SELECT @new_id = id_answer, @new_id_user = id_user, @new_answer = answer, @new_insert_date = insert_date,
	@new_id_user_update = id_user_update, @new_update_date = update_date
	FROM inserted

-- creamos la cadena de los datos nuevos
	SET @new_data = 'id_answer = ' + convert(varchar, @new_id) + '| id_user = ' +
	CONVERT(varchar, @new_id_user) + '| answer = ' + @new_answer + '| insert_date = '
	+ CONVERT(VARCHAR, @new_insert_date) + '| id_user_update = ' +	CONVERT(VARCHAR, @new_id_user_update) +
	'| update_date = ' + CONVERT(VARCHAR, @new_update_date)

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'INSERT', 'TBL_ANSWERS', @new_data , '', getdate())

-- Trigger para la tabla TBL_ANSWER UPDATE
CREATE OR REPLACE TRIGGER dbo.tg_update_answer
ON dbo.tbl_answers
FOR UPDATE
AS
-- Declaramos variables
	DECLARE @new_id INT, @new_id_user INT, @new_answer VARCHAR(500), @new_insert_date DATETIME,
	@new_id_user_update INT, @new_update_date DATETIME, @new_data VARCHAR(400),
    @old_id INT, @old_id_user INT, @old_answer VARCHAR(500), @old_insert_date DATETIME,
	@old_id_user_update INT, @old_update_date DATETIME, @old_data VARCHAR(400),
    @id INT

--	Obtenemos los datos nuevos
	SELECT @new_id = id_answer, @new_id_user = id_user, @new_answer = answer, @new_insert_date = insert_date,
	@new_id_user_update = id_user_update, @new_update_date = update_date
	FROM inserted

-- creamos la cadena de los datos nuevos
	SET @new_data = 'id_answer = ' + convert(varchar, @new_id) + '| id_user = ' +
	CONVERT(varchar, @new_id_user) + '| answer = ' + @new_answer + '| insert_date = '
	+ CONVERT(VARCHAR, @new_insert_date) + '| id_user_update = ' +	CONVERT(VARCHAR, @new_id_user_update) +
	'| update_date = ' + CONVERT(VARCHAR, @new_update_date)

--	Obtenemos los datos viejos
	SELECT @old_id = id_answer, @old_id_user = id_user, @old_answer = answer, @old_insert_date = insert_date,
	@old_id_user_update = id_user_update, @old_update_date = update_date
	FROM deleted

-- creamos la cadena de los datos viejos
	SET @old_data = 'id_answer = ' + convert(varchar, @old_id) + '| id_user = ' +
	CONVERT(varchar, @old_id_user) + '| answer = ' + @old_answer + '| insert_date = '
	+ CONVERT(VARCHAR, @old_insert_date) + '| id_user_update = ' +	CONVERT(VARCHAR, @old_id_user_update) +
	'| update_date = ' + CONVERT(VARCHAR, @old_update_date)

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'UPDATE', 'TBL_ANSWERS', @new_data , @old_data, getdate())

-- Triger para la tabla TBL_KEYWORDS INSERT
CREATE OR REPLACE TRIGGER dbo.tg_insert_keyword
ON dbo.tbl_keywords
FOR INSERT
AS
-- Declaramos variables
	DECLARE 
	@new_id INT, 
	@new_id_answer INT, 
	@new_keyword VARCHAR(25), 
	@new_data VARCHAR(1000),
	@id INT

--	Obtenemos los datos nuevos
	SELECT @new_id = id_keyword, @new_id_answer = id_answer, @new_keyword = keyword
	FROM inserted

-- creamos la cadena de los datos nuevos

	SET @new_data = 'id_keyword = ' + CONVERT(VARCHAR, @new_id) + '| id_answer = ' +
	CONVERT(VARCHAR, @new_id_answer) + '| keyword = ' + @new_keyword

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'INSERT', 'TBL_KEYWORDS', @new_data , '', getdate())

-- Triger para la tabla TBL_KEYWORDS DELETE
CREATE OR REPLACE TRIGGER dbo.tg_delete_keyword
ON dbo.tbl_keywords
FOR DELETE
AS
-- Declaramos variables
	DECLARE 
	@old_id INT, 
	@old_id_answer INT, 
	@old_keyword VARCHAR(25), 
	@old_data VARCHAR(1000),
	@id INT

--	Obtenemos los datos nuevos
	SELECT @old_id = id_keyword, @old_id_answer = id_answer, @old_keyword = keyword
	FROM deleted

-- creamos la cadena de los datos nuevos

	SET @old_data = 'id_keyword = ' + CONVERT(VARCHAR, @old_id) + '| id_answer = ' +
	CONVERT(VARCHAR, @old_id_answer) + '| keyword = ' + @old_keyword

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'DELETE', 'TBL_KEYWORDS', '' , @old_data, getdate())

-- Triger para la tabla tbl_patient INSERT
CREATE OR REPLACE TRIGGER dbo.tg_insert_patient
ON dbo.tbl_patient
FOR INSERT
AS
-- Declaramos variables
	DECLARE
	@new_id INT,
	@new_name VARCHAR(45),
	@new_last_name VARCHAR(45),
	@new_birthdate DATE,
	@new_gender INT,
	@new_personality VARCHAR(45),
	@new_ci VARCHAR(45),
	@new_character VARCHAR(45),
	@new_email VARCHAR(50),
	@new_id_user INT,
	@new_insert_date DATETIME,
	@new_id_user_update INT,
	@new_update_date DATETIME,
	@id INT,
	@new_data VARCHAR(400)

--	Obtenemos los datos nuevos
	SELECT @new_id = id_patient, @new_name = name, @new_last_name = last_name, @new_birthdate = birthdate,
	@new_gender = gender, @new_personality = personality, @new_ci = ci, @new_character = [character],
	@new_email = email, @new_id_user =  id_user, @new_insert_date =  insert_date,
	@new_id_user_update =  id_user_update, @new_update_date  = update_date
	FROM inserted


-- creamos la cadena de los datos nuevos
	SET @new_data = 'id_user = ' + CONVERT(VARCHAR, @new_id) + '| name = ' + @new_name + '| last_name = ' + @new_last_name +
	'| birthdate = ' + CONVERT(VARCHAR, @new_birthdate) + '| gender = ' + CONVERT(VARCHAR, @new_gender) + '| personality = ' + @new_personality +
	'| ci = ' + @new_ci + '| character = ' + @new_character + '| email = ' + @new_email + '| id_user = ' + CONVERT(VARCHAR, @new_id_user) +
	'| insert_date = ' + CONVERT(VARCHAR, @new_insert_date) + '| id_user_update = ' + CONVERT(VARCHAR, @new_id_user_update) +
	'| update_date = ' + CONVERT(VARCHAR, @new_update_date)

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'INSERT', 'TBL_PATIENT', @new_data , '', getdate())

-- Triger para la tabla tbl_patient UPDATE
CREATE OR REPLACE TRIGGER dbo.tg_update_patient
ON dbo.tbl_patient
FOR UPDATE
AS
-- Declaramos variables
	DECLARE
	@new_id INT,
	@new_name VARCHAR(45),
	@new_last_name VARCHAR(45),
	@new_birthdate DATE,
	@new_gender INT,
	@new_personality VARCHAR(45),
	@new_ci VARCHAR(45),
	@new_character VARCHAR(45),
	@new_email VARCHAR(50),
	@new_id_user INT,
	@new_insert_date DATETIME,
	@new_id_user_update INT,
	@new_update_date DATETIME,
	@old_id INT,
	@old_name VARCHAR(45),
	@old_last_name VARCHAR(45),
	@old_birthdate DATE,
	@old_gender INT,
	@old_personality VARCHAR(45),
	@old_ci VARCHAR(45),
	@old_character VARCHAR(45),
	@old_email VARCHAR(50),
	@old_id_user INT,
	@old_insert_date DATETIME,
	@old_id_user_update INT,
	@old_update_date DATETIME,
	@id INT,
	@new_data VARCHAR(400),
	@old_data VARCHAR(400)

--	Obtenemos los datos nuevos
	SELECT @new_id = id_patient, @new_name = name, @new_last_name = last_name, @new_birthdate = birthdate,
	@new_gender = gender, @new_personality = personality, @new_ci = ci, @new_character = [character],
	@new_email = email, @new_id_user =  id_user, @new_insert_date =  insert_date,
	@new_id_user_update =  id_user_update, @new_update_date  = update_date
	FROM inserted


-- creamos la cadena de los datos nuevos
	SET @new_data = 'id_user = ' + CONVERT(VARCHAR, @new_id) + '| name = ' + @new_name + '| last_name = ' + @new_last_name +
	'| birthdate = ' + CONVERT(VARCHAR, @new_birthdate) + '| gender = ' + CONVERT(VARCHAR, @new_gender) + '| personality = ' + @new_personality +
	'| ci = ' + @new_ci + '| character = ' + @new_character + '| email = ' + @new_email + '| id_user = ' + CONVERT(VARCHAR, @new_id_user) +
	'| insert_date = ' + CONVERT(VARCHAR, @new_insert_date) + '| id_user_update = ' + CONVERT(VARCHAR, @new_id_user_update) +
	'| update_date = ' + CONVERT(VARCHAR, @new_update_date)

--	Obtenemos los datos viejos
	SELECT @old_id = id_patient, @old_name = name, @old_last_name = last_name, @old_birthdate = birthdate,
	@old_gender = gender, @old_personality = personality, @old_ci = ci, @old_character = [character],
	@old_email = email, @old_id_user =  id_user, @old_insert_date =  insert_date,
	@old_id_user_update =  id_user_update, @old_update_date  = update_date
	FROM deleted

-- creamos la cadena de los datos viejos
	SET @old_data = 'id_user = ' + CONVERT(VARCHAR, @old_id) + '| name = ' + @old_name + '| last_name = ' + @old_last_name +
	'| birthdate = ' + CONVERT(VARCHAR, @old_birthdate) + '| gender = ' + CONVERT(VARCHAR, @old_gender) + '| personality = ' + @old_personality +
	'| ci = ' + @old_ci + '| character = ' + @old_character + '| email = ' + @old_email + '| id_user = ' + CONVERT(VARCHAR, @old_id_user) +
	'| insert_date = ' + CONVERT(VARCHAR, @old_insert_date) + '| id_user_update = ' + CONVERT(VARCHAR, @old_id_user_update) +
	'| update_date = ' + CONVERT(VARCHAR, @old_update_date)

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'UPDATE', 'TBL_PATIENT', @new_data , @old_data, getdate())

-- Triger para la tabla TBL_CHAT_HISTORY INSERT
CREATE OR REPLACE TRIGGER dbo.tg_insert_chat_history
ON dbo.tbl_chat_history
FOR INSERT
AS
-- Declaramos variables
	DECLARE 
	@new_id_chat_history INT,
	@new_id_patient INT,
	@new_message VARCHAR(500),
	@new_id_answer INT,
	@new_update_date DATETIME,
	@new_data VARCHAR(1000),
	@id INT

--	Obtenemos los datos nuevos
	SELECT @new_id_chat_history = id_chat_history, @new_id_patient = id_patient, @new_message = message, 
	@new_id_answer = id_answer, @new_update_date = update_date
	FROM inserted

-- creamos la cadena de los datos nuevos

	SET @new_data = 'id_chat_hitory = ' + CONVERT(VARCHAR, @new_id_chat_history) + '| id_patient = ' + CONVERT(VARCHAR, @new_id_patient) +
	'| message = ' + @new_message + '| id_answer = ' + CONVERT(VARCHAR, @new_id_answer) + '| update_datetime = ' + CONVERT(VARCHAR, @new_update_date)

-- Obtenemos el id de la bitacora
	SELECT @id = isNull(MAX(id_binnacle), 0)
	FROM dbfriday.dbo.tbl_binnacle

	INSERT INTO dbo.tbl_binnacle(id_binnacle, operation, table_name, new_data, old_data, dt)
	VALUES(@id + 1, 'INSERT', 'TBL_CHAT_HISTORY', @new_data , '', getdate())