FROM postgres:17.5@sha256:6efd0df010dc3cb40d5e33e3ef84acecc5e73161bd3df06029ee8698e5e12c60

RUN localedef -i pl_PL -c -f UTF-8 -A /usr/share/locale/locale.alias pl_PL.UTF-8
ENV LANG=pl_PL.UTF-8
ENV LC_COLLATE=pl_PL.UTF-8
ENV LC_CTYPE=pl_PL.UTF-8
ENV LC_MESSAGES=en_US.UTF-8
