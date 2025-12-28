ARG BASE_IMAGE
ARG NODE_VERSION=18
FROM $BASE_IMAGE

# Install prerequisites and Node.js (configurable via build ARG `NODE_VERSION`)
RUN apt-get update \
    && apt-get install -y curl ca-certificates gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Verify versions
RUN node --version && npm --version
