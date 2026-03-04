@echo off
cd /d "%~dp0"

if exist .git-uno\index.lock (
    echo Removendo travamento anterior...
    del .git-uno\index.lock
)

echo Adicionando arquivos...
git add -A

echo Criando commit...
git commit -m "auto %date% %time%"

echo Detectando branch atual...
for /f "delims=" %%i in ('git rev-parse --abbrev-ref HEAD') do set BRANCH=%%i

echo Enviando para o GitHub...
git push origin %BRANCH%

echo Concluido.