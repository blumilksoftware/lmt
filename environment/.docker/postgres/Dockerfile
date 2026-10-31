FROM postgres:17.11@sha256:31ba9c94a03ada9988f2bb493a22a75eef3a185884533e5cdbcd498ea835b08f

RUN localedef -i pl_PL -c -f UTF-8 -A /usr/share/locale/locale.alias pl_PL.UTF-8
ENV LANG=pl_PL.UTF-8
ENV LC_COLLATE=pl_PL.UTF-8
ENV LC_CTYPE=pl_PL.UTF-8
ENV LC_MESSAGES=en_US.UTF-8
