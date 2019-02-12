import { TestBed } from '@angular/core/testing';

import { AnglaraService } from './anglara.service';

describe('AnglaraService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: AnglaraService = TestBed.get(AnglaraService);
    expect(service).toBeTruthy();
  });
});
