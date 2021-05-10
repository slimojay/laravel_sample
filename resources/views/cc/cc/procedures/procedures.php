<?php
//file holds sql statements
//created by Ojiodu Joachim 04/02/2021

$loginSql = "CREATE PROCEDURE selectUsers @email nvarchar(500), @username nvarchar(500)
AS
SELECT * FROM users WHERE email = @email OR username = @username
GO";

?>