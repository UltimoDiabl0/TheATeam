# TheATeam
A repository to be used for CS3141 Team Software Project

docker build -t devenv .


docker run -d -p 3000:80 --name devenv -v [project directory]/public:/var/www/html devenv


now it should be on localhost:3000
