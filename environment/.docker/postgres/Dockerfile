FROM postgres:17.6@sha256:00bc86618629af00d2937fdc5a5d63db3ff8450acf52f0636ec813c7f4902929

RUN localedef -i pl_PL -c -f UTF-8 -A /usr/share/locale/locale.alias pl_PL.UTF-8
ENV LANG=pl_PL.UTF-8
ENV LC_COLLATE=pl_PL.UTF-8
ENV LC_CTYPE=pl_PL.UTF-8
ENV LC_MESSAGES=en_US.UTF-8
