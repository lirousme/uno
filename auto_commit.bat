@echo off
cd /d "%~dp0"

echo Adicionando arquivos...
git add -A

echo Criando commit...
git commit -m "x"

echo Detectando branch atual...
for /f "delims=" %%i in ('git rev-parse --abbrev-ref HEAD') do set BRANCH=%%i

echo Enviando para o GitHub...
git push -u origin %BRANCH%

echo Concluido.
pause