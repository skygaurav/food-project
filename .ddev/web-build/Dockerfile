ARG BASE_IMAGE
FROM $BASE_IMAGE

# Install prerequisites and Node.js LTS (18.x) from NodeSource
RUN apt-get update \
    && apt-get install -y curl ca-certificates gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Verify versions
RUN node --version && npm --version
