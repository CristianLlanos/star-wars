# Install dependencies only when needed
FROM node:24-alpine

WORKDIR /app

RUN apk add --no-cache libc6-compat

ENV NODE_ENV=development
ENV NEXT_TELEMETRY_DISABLED=1

RUN addgroup --system --gid 1001 nodejs
RUN adduser --system --uid 1001 nextjs

USER nextjs

EXPOSE 8100

CMD ["sh", "-c", "npm ci && npm run setup && npm run dev"]
