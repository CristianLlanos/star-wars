import { render, screen, waitFor } from '@testing-library/react';
import userEvent from '@testing-library/user-event';
import { vi } from 'vitest';
import Home from '../page';
import { SearchFormSection } from '@/components/SearchFormSection';

vi.mock('lodash.debounce', () => ({
  default: <T extends (...args: never[]) => unknown>(fn: T) => {
    const debounced = ((...args: Parameters<T>) => fn(...args)) as T & { cancel: () => void };
    debounced.cancel = vi.fn();
    return debounced;
  }
}));

describe('Home search form', () => {
  it('shows query error when submitting short text', async () => {
    render(<Home/>);

    await userEvent.type(screen.getByPlaceholderText(/chewbacca/i), 'a');
    await userEvent.click(screen.getByRole('button', { name: /search/i }));

    expect(await screen.findByText('Enter at least 2 characters.')).toBeVisible();
  });
});

describe('SearchFormSection loading state', () => {
  it('disables the search button while submitting', async () => {
    const user = userEvent.setup();

    let resolveSubmit!: () => void;
    const onSubmit = vi.fn().mockImplementation(() => new Promise<void>((resolve) => {
      resolveSubmit = resolve;
    }));

    render(<SearchFormSection onSubmit={onSubmit}/>);

    await user.type(screen.getByRole('searchbox'), 'an');

    await waitFor(() => {
      expect(onSubmit).toHaveBeenCalledTimes(1);
    });

    const loadingButton = await screen.findByRole('button', { name: /searching/i });
    expect(loadingButton).toBeDisabled();

    resolveSubmit();

    const idleButton = await screen.findByRole('button', { name: /^search$/i });
    expect(idleButton).toBeEnabled();
  });
});
