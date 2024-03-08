FROM node:21.4.0-bullseye-slim as nodejs

ARG USER_NAME=host-user
ARG USER_ID=1001

RUN adduser --disabled-password --uid ${USER_ID} ${USER_NAME}

# Kopiuje pliki i binarie Node.js z obrazu node do odpowiednich lokalizacji w obrazie końcowym.
COPY --from=node --chown=${USER_NAME}:root /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node --chown=${USER_NAME}:root /usr/local/bin/node /usr/local/bin/node

# Tworzy symboliczne linki dla npm i npx.
RUN rm -f /usr/local/bin/npx \
    && rm -f /usr/local/bin/npm \
    && ln --symbolic /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && chown --no-dereference ${USER_NAME}:root /usr/local/bin/npm \
    && ln --symbolic /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx \
    && chown --no-dereference ${USER_NAME}:root /usr/local/bin/npx



USER ${USER_NAME}

WORKDIR /application

ENTRYPOINT ["/usr/local/bin/npm"]
