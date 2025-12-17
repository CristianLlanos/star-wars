# Star Wars Web

A Next.js 16 web application for searching Star Wars movies and characters, built with React 19, TypeScript, and Tailwind CSS.

## Features

- **Search Interface**: Search for Star Wars movies by title or people by name
- **Detail Pages**: View detailed information about specific movies and characters
- **Analytics Dashboard**: View usage statistics and popular queries
- **Real-time Results**: Debounced search with loading indicators

## Tech Stack

- **Framework**: Next.js 16.0.10 (App Router)
- **React**: 19.2.1 with React Compiler enabled
- **TypeScript**: Type-safe development
- **Styling**: Tailwind CSS 4
- **Forms**: React Hook Form with Zod validation
- **HTTP Client**: Axios
- **Testing**: Vitest with React Testing Library

## Project Structure

```
star-wars-web/src/
├── api/                    # API integration layer
│   ├── StarWars.ts         # Core API client
│   ├── types.ts            # TypeScript type definitions
│   ├── useMovieById.ts     # Hook for fetching movie details
│   ├── useMoviesSearchByTitle.ts  # Hook for movie search
│   ├── usePeopleById.ts    # Hook for fetching person details
│   ├── usePeopleSearchByName.ts   # Hook for people search
│   ├── useStarWarsRequest.ts      # Base request hook with error handling
│   └── useStats.ts         # Hook for fetching analytics data
├── app/                    # Next.js App Router pages
│   ├── dashboard/          # Analytics dashboard page
│   ├── movies/             # Movie detail pages
│   ├── people/             # People detail pages
│   ├── layout.tsx          # Root layout
│   └── page.tsx            # Home page (search interface)
├── components/             # Reusable React components
│   ├── ResultsSection.tsx  # Search results display
│   └── SearchFormSection.tsx  # Search form UI
├── forms/                  # Form schemas and validation
│   └── SearchForm.ts       # Search form Zod schema
└── hooks/                  # Custom React hooks
    └── useLoading.ts       # Loading state management hook
```

## Setup

The web app is designed to run inside Docker as part of the full stack. However, you can also run it standalone:

### Environment Variables

Copy the example environment file optimized for Docker setup:
```zsh
npm run setup
```

This creates `.env.local` with:
```env
# Client-side API calls (browser)
NEXT_PUBLIC_API_BASE_URL=http://localhost:8800

# Server-side API calls (Docker network)
API_BASE_URL=http://api:8000
```

### Install Dependencies

```zsh
npm install
```

### Development Server

```zsh
npm run dev
```

Open [http://localhost:8100](http://localhost:8100) in your browser.

## Key Hooks

### `useStarWarsRequest`
Base hook that provides standardized error handling, loading states, and request execution for all API calls. Features:
- Automatic input sanitization
- Client/server error discrimination
- Loading state management via `useLoading`
- Reset functionality

### `useLoading`
Generic hook for wrapping async operations with loading states. Uses the `itLoads` wrapper function to automatically set loading state before/after task execution.

### Search Hooks
- `useMoviesSearchByTitle`: Search movies by title with debounced input
- `usePeopleSearchByName`: Search people by name with debounced input

### Detail Hooks
- `useMovieById`: Fetch detailed movie information
- `usePeopleById`: Fetch detailed person information

### Analytics Hook
- `useStats`: Fetch dashboard statistics (top queries, request times, popular hours)

## Pages

### Home (`/`)
Main search interface with:
- Category toggle (Movies/People)
- Search input with debounced queries
- Results display with loading states
- Error handling

### Dashboard (`/dashboard`)
Analytics dashboard displaying:
- Top movie queries (percentage)
- Top person queries (percentage)
- Average request time by endpoint
- Popular request hours
- Loading indicator during data fetch

### Movie Detail (`/movies/[id]`)
Detailed view of a specific movie

### Person Detail (`/people/[id]`)
Detailed view of a specific character

## Scripts

- `npm run dev` - Start development server on port 8100
- `npm run build` - Build production bundle
- `npm start` - Start production server on port 8100
- `npm run lint` - Run ESLint
- `npm test` - Run Vitest test suite
- `npm run setup` - Copy `.example.env.local` to `.env.local`

## Docker Integration

When running via `./stack start` from the project root:
- Web app runs on port **8900** (mapped from container port 8100)
- Hot reload enabled via bind-mounted source directory
- Uses Docker network to communicate with API container
- Automatically waits for "✓ Ready" before marking as available
