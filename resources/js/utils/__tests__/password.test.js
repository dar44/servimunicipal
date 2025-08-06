import { toggleType } from '../password';

test('toggleType switches password visibility', () => {
  expect(toggleType('password')).toBe('text');
  expect(toggleType('text')).toBe('password');
});
