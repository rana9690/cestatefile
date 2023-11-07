export CPATH=../lib/digital.signature-0.1.0.jar:../config/ 
echo $CPATH
java -classpath $CPATH org.springframework.boot.loader.JarLauncher -Xms256m -Xmx512m -server -Xloggc:../logs/gc.log -verbose:gc -XX:+PrintGCDetails -XX:+HeapDumpOnOutOfMemoryError -XX:HeapDumpPath=../logs -Dcom.sun.management.jmxremote -Dcom.sun.management.jmxremote.port=9888 -Dcom.sun.management.jmxremote.ssl=FALSE -Dcom.sun.management.jmxremote.authenticate=FALSE -Dlogging.config=../config/log4j2.xml -Dspring.config.location=../config/application.properties,../config/config.properties 
