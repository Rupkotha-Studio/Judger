#docker rmi $(docker images --filter "dangling=true" -q --no-trunc)
docker build -t judger_final:1 .
docker rm -f $(docker ps -aq)
docker run -p 80:80 --privileged -d judger_final:1
