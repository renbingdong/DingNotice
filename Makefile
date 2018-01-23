RPMBUILD_ROOT=${HOME}/rpmbuild

NAME=DN-renbd

all: init  fetch build copy

init:
	mkdir -p ${RPMBUILD_ROOT}/{BUILD,BUILDROOT,RPMS,SOURCES,SPECS,SRPMS}

fetch:
	tar cfz ${RPMBUILD_ROOT}/SOURCES/${NAME}.tgz *

build:
	rpmbuild -ba $NAME}.spec

copy:
	cp ${RPMBUILD_ROOT}/RPMS/noarch/*${NAME}-${VERSION}*rpm  .



