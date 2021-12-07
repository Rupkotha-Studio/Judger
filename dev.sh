docker rm -f $(docker ps -aq)
docker rmi $(docker images --filter "dangling=true" -q --no-trunc)
docker build -t judger:dev .
docker run -p 80:80 -v $(pwd):/var/www/html/ --privileged -d judger:dev
# docker run -p 80:80 --privileged -d judger:dev

