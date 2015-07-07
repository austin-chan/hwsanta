//
//  SantaChatViewController.h
//  HopingForAWish
//
//  Created by Austin Chan on 12/7/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SantaChatViewController : UIViewController
@property (weak, nonatomic) IBOutlet UIScrollView *scrollView;
@property (weak, nonatomic) IBOutlet UIButton *messageButton;
@property (weak, nonatomic) IBOutlet UIActivityIndicatorView *activity;
- (IBAction)sendMessage:(id)sender;

@end
